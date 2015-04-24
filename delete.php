<?php
    $id = null;
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

        $id = $_POST['id'];
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "Delete from tasks where id=?";
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array($id));
        $PDO = null;
        header("Location: index.php");
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
        <div class="row">
            <h3>Delete a Task</h3>
        </div>
    <form method="POST" action="delete.php">
        <input type="hidden" name="id" value="<?php echo $id;?>" />
        <p class="bg-danger" style="padding: 10px;">Are you sure to delete ?</p>
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Yes</button>
            <a class="btn btn btn-default" href="index.php">No</a>
        </div>
    </form>
                
    </div> 
    </div> 
</body>
</html>
