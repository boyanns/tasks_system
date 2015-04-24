<?
session_start();

if(!isset( $_SESSION['user_id'] ))
{
	header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRUD Task</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  
	<div class="jumbotron">
    	<h1>CRUD Task</h1>
		<p>As a user I can CRUD tasks for any other user.</p> 
	</div>

    <p><a class="btn btn-xs btn-success" href="#createModal" data-toggle="modal">Create Task</a></p>

    <table class="table table-striped table-bordered table-hover">
    <tr>
        <th>Owner</th>
        <th>Performer</th>
        <th>State</th>
        <th>Creation Date</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    <tbody>
    <?php
    include 'db.php';
    $sql = 'SELECT * FROM tasks ORDER BY ID DESC';
    foreach ($PDO->query($sql) as $row) {
        echo '<tr>';
		$owner = $row['Owner'];
		echo '<td>'.'<a href="#updateModal" data-toggle="modal" id="'.$row['ID'].'">'. get_owner($owner) . '</a>';
		$performer = $row['Performer'];
		echo '<td>'. get_performer($performer) . '</td>';
        echo '<td>'. $row['State'] . '</td>';
        echo '<td>'. $row['CreationDate'] . '</td>';
        echo '<td>'. $row['Description'] . '</td>';
        echo '<td><a class="btn btn-xs btn-success" href="delete.php?id='.$row['ID'].'">Delete</a></td>';
        echo '</tr>';
    }
	function get_owner($owner){
		global $PDO;
		$sth = $PDO->prepare("SELECT username FROM users WHERE user_id = '$owner'");
		$sth->execute();
		
		$result = $sth->fetch();
		return $result[0];
	}
	function get_performer($performer){
		global $PDO;
		$sth = $PDO->prepare("SELECT username FROM users WHERE user_id = '$performer'");
		$sth->execute();
		
		$result = $sth->fetch();
		return $result[0];
	}
	$PDO = null;
    ?>
    </tbody>
    </table>
    </div>

    <div id="updateModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">CRUD Task</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h3>&nbsp;&nbsp;Update a Task</h3>
                    </div>

					<?php
						//echo "r id is ".$row['ID'];
					    $id = $row['ID'];
					    if(!empty($_GET['id']))
					    {
					        $id = $_GET['id'];
					    }
					    if($id == null)
					    {
					        header("Location: index.php");
					    } 
					    if ( !empty($_POST))
					    {
					        require 'db.php';
					
					        $ownerError = null;
					        $performerError = null;
					        $stateError = null;
					        $descriptionError = null;        
					
					        $owner = $_POST['owner'];
					        $performer = $_POST['performer'];
					        $state = $_POST['state'];
					        $description = $_POST['description'];
					        
					      
					        
					        if(empty($performer)) {
					            $performerError = 'Please enter Performer';
					            $valid = false;
					        }
					        
					        if(empty($state)) {
					            $stateError = 'Please enter State';
					            $valid = false;
					        }
					        
					        if(empty($description)) {
					            $descriptionError = 'Please select Description';
					            $valid = false;
					        }
					        
					        if ($valid) {
					            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					            $sql = "Update tasks set owner=?,performer=?,state=?,description=? where id=?";
					            $stmt = $PDO->prepare($sql);
					            $stmt->execute(array($owner,$performer,$state,$description,$id));
					            $PDO = null;
					            header("Location: index.php");
					        }
					    }
					    else{
					        require 'db.php';
					        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					        $sql = "SELECT * FROM tasks where id = ?";
					        $stmt = $PDO->prepare($sql);
					        $stmt->execute(array($id));
					        $data = $stmt->fetch(PDO::FETCH_ASSOC);
					        //$PDO = null;
					        
							if (empty($data)){
					            header("Location: index.php");
					        }
					        
							$owner  = $data['Owner'];
							$owner = get_owner($owner);							
					        $performer  = $data['Performer'];
							$performer = get_performer($performer);
					        $state    = $data['State'];
					        $description = $data['Description'];

							//$PDO = null;
					    }
					?>
            
					    <form method="POST" action="update.php?id=<?php echo $id?>">
						<div class="form-group <?php echo !empty($ownerError)?'has-error':'';?>">
					        <label for="inputOwner">Owner</label>

					        <input type="text" class="form-control" required="required" id="inputOwnerSession" value=<?=$owner?> name="ownersession" placeholder="Owner" disabled>
							<input type="hidden" id="inputOwner" name="owner" value=<?=$_SESSION['user_id'];?>>
					        <span class="help-block"><?php echo $ownerError;?></span>
					    </div>
					    <div class="form-group <?php echo !empty($performerError)?'has-error':'';?>">
					        <label for="inputPerformer">Performer</label>
					        					        <select class="form-control" required="required" id="inputPerformer" name="performer" >
					        <option></option>
							<?
								$me_id = $_SESSION['user_id'];
								$sql = "SELECT * FROM users WHERE user_id != '$me_id'";
							    foreach ($PDO->query($sql) as $row) {

								$pid = $row['user_id'];
								?>
								<option value="open" <?php echo $row['user_id'] == $data['Performer'] ?'selected':'';?>><?=get_performer($pid)?></option>
								<?
								}
							?>

					        </select>

					        <span class="help-block"><?php echo $performerError;?></span>
					    </div>
					    <div class="form-group <?php echo !empty($stateError)?'has-error':'';?>">
					        <label for="inputState">State</label>
					        <select class="form-control" required="required" id="inputState" name="state" >
					        <option></option>
					        <option value="open" <?php echo $state == 'open'?'selected':'';?>>Open</option>
					        <option value="done" <?php echo $state == 'done'?'selected':'';?>>Done</option>
					        </select>
					    <span class="help-block"><?php echo $stateError;?></span>        
					    </div>    
						<div class="form-group <?php echo !empty($descriptionError)?'has-error':'';?>">
					        <label for="inputDescription">Description</label>
					        <input type="text" class="form-control" required="required" id="inputDescription" value="<?php echo !empty($description)?$description:'';?>" name="description" placeholder="Description">
					        <span class="help-block"><?php echo $descriptionError;?></span>
					    </div>
					    
					    <div class="form-actions">
					        <button type="submit" class="btn btn-primary">Update</button>
					        <a class="btn btn btn-default" href="index.php">Close</a>
					    </div>
					    </form>
                </div>               
            </div>
        </div>
    </div>

<!-- create -->

    <div id="createModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">CRUD Task</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h3>&nbsp;&nbsp;Create a Task</h3>
                    </div>
					
					<?php 
					require 'db.php';
					$owner = $_SESSION['user_id'];
					$owner = get_owner($owner);
				    if ( !empty($_POST)) {
				        
				        
				        $ownerError = null;
				        $performerError = null;
				        $stateError = null;
				        $descriptionError = null;
				        
				        $owner = $_POST['owner'];
				        $performer  = $_POST['performer'];
				        $state = $_POST['state'];
				        $description = $_POST['description'];
				        
				        if(empty($performer)) {
				            $performerError = 'Please enter Performer';
				            $valid = false;
				        }
				        
				        if(empty($state)) {
				            $stateError = 'Please enter State';
				            $valid = false;
				        }
				        
				        if(empty($description)) {
				            $descriptionError = 'Please select Description';
				            $valid = false;
				        }
				               
				        if ($valid) {
				            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				            $sql = "INSERT INTO tasks (owner,performer,state,description,creationdate) values(?, ?, ?, ?, NOW())";
				            $stmt = $PDO->prepare($sql);
				            $stmt->execute(array($owner,$performer,$state,$description));
				            $PDO = null;
				            header("Location: index.php");
				        }
				    }
				?>            
					    <form method="POST" action="create.php">
						<div class="form-group <?php echo !empty($ownerError)?'has-error':'';?>">
					        <label for="inputOwner">Owner</label>
					        <input type="text" class="form-control" required="required" id="inputOwnerSession" value=<?=$owner?> name="ownersession" placeholder="Owner" disabled>
							<input type="hidden" id="inputOwner" name="owner" value=<?=$_SESSION['user_id'];?>>
					        <span class="help-block"><?php echo $ownerError;?></span>
					    </div>

							<div class="form-group <?php echo !empty($performerError)?'has-error':'';?>">
					        <label for="inputPerformer">Performer</label>
					        <select class="form-control" required="required" id="inputPerformer" name="performer" >
					        <option></option>
							<?
								$me_id = $_SESSION['user_id'];
								$sql = "SELECT * FROM users WHERE user_id != '$me_id'";
							    foreach ($PDO->query($sql) as $row) {
									echo '<option value="'.$row['user_id'].'">'.get_performer($row['user_id']).'</option>';
							    }
							?>

					        </select>
					    <span class="help-block"><?php echo $performerError;?></span>        
					    </div>    

					    <div class="form-group <?php echo !empty($stateError)?'has-error':'';?>">
					        <label for="inputState">State</label>
					        <select class="form-control" required="required" id="inputState" name="state" >
					        <option></option>
					        <option value="open" <?php echo $state == 'open'?'selected':'';?>>Open</option>
					        <option value="done" <?php echo $state == 'done'?'selected':'';?>>Done</option>
					        </select>
					    <span class="help-block"><?php echo $stateError;?></span>        
					    </div>    
						<div class="form-group <?php echo !empty($descriptionError)?'has-error':'';?>">
					        <label for="inputDescription">Description</label>
					        <input type="text" class="form-control" required="required" id="inputDescription"  name="description" placeholder="Description">
					        <span class="help-block"><?php echo $descriptionError;?></span>
					    </div>
					    
					    <div class="form-actions">
					        <button type="submit" class="btn btn-primary">Create</button>
					        <a class="btn btn btn-default" href="index.php">Close</a>
					    </div>
					    </form>
                </div>               
            </div>
        </div>

    </div>
	<center><p><a href="logout.php">Logout</a></p></center>
<!-- end create -->

</div>
</body>
</html>
