<?php 
    if ( !empty($_POST)) {
        require 'db.php';
        
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
   
                    <div class="row">
                        <h3>Create a Task</h3>
                    </div>
            
                    <form method="POST" action="">
    <div class="form-group <?php echo !empty($ownerError)?'has-error':'';?>">
        <label for="inputOwner">Owner</label>
        <input type="text" class="form-control" required="required" id="inputOwner" value="<?php echo !empty($owner)?$owner:'';?>" name="owner" placeholder="Owner">
        <span class="help-block"><?php echo $ownerError;?></span>
    </div>
    <div class="form-group <?php echo !empty($performerError)?'has-error':'';?>">
        <label for="inputPerformer">Performer</label>
        <input type="text" class="form-control" required="required" id="inputPerformer" value="<?php echo !empty($performer)?$performer:'';?>" name="performer" placeholder="Performer">
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
        <button type="submit" class="btn btn-success">Create</button>
        <a class="btn btn-default" href="index.php">Back</a>
    </div>
</form>
                
    </div> 
    </div> 
</body>
</html>
