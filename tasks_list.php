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
  <title>View My Tasks List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0-rc2/css/bootstrap.css">
 
 <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
 <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0-rc2/js/bootstrap.min.js"></script>
  <script src="js/jquery.tablesorter.js"></script>
  <script src="js/jquery.tablesorter.widgets.js"></script>

   <script>

$(document).ready(function(){
$(function(){
$("#task_table").tablesorter();
});
});
</script>

   <script>

$(document).ready(function(){
$(function(){
$("#task_table2").tablesorter();
});
});
</script>

</head>
<body>

<div class="container">
  
	<div class="jumbotron">
    	<h1>View My Tasks List</h1>
		<p>As a user I want to see all tasks I have created and all tasks that are assigned to me.</p> 
	</div>

	<p>Tasks created by me</p>
	
	<div class="table-responsive"> 
        <table class="table tablesorter table-bordered" id="task_table">
            <thead>
                <tr>
                    <th>Creation Date</th>
                    <th>Description</th>
                    <th>Owner</th>
                    <th>State</th>
                </tr>
            </thead>
           <tbody>
	    <?php
	    include 'dba.php';

		$me_id = $_SESSION['user_id'];		

	    $sql = "SELECT * FROM tasks WHERE Owner = '$me_id' ORDER BY ID DESC";
	    foreach ($PDO->query($sql) as $row) {
	        echo '<tr>';
			echo '<td>'. $row['CreationDate'] . '</td>';
			echo '<td>'. $row['Description'] . '</td>';
			$owner = $row['Owner'];
			echo '<td>'.get_owner($owner).'</td>';			
	        echo '<td>'. $row['State'] . '</td>';	        
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

	<p>Tasks assigned to me</p>
	
	<div class="table-responsive"> 
        <table class="table tablesorter table-bordered" id="task_table2">
            <thead>
                <tr>
                    <th>Creation Date</th>
                    <th>Description</th>
                    <th>Owner</th>
                    <th>State</th>
                </tr>
            </thead>
            <?php
		    include 'dba.php';
		    $sql = "SELECT * FROM tasks WHERE Performer = '$me_id' ORDER BY ID DESC";
		    foreach ($PDO->query($sql) as $row) {
		        echo '<tr>';
				echo '<td>'. $row['CreationDate'] . '</td>';
				echo '<td>'. $row['Description'] . '</td>';
				$owner = $row['Owner'];
				echo '<td>'.get_owner($owner).'</td>';			
		        echo '<td>'. $row['State'] . '</td>';	        
		        echo '</tr>';
		    }
			
			$PDO = null;
		    ?>
        </table>
   
	</div>  

	<p><a href="logout.php">Logout</a></p>

</div>

</body>
</html>

