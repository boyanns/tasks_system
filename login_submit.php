<?php

session_start();

if(isset( $_SESSION['user_id'] ))
{
    $message = 'Users is already logged in';
}

if(!isset( $_POST['username'], $_POST['password']))
{
    $message = 'Please enter a valid username and password';
}
else
{
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $password = sha1( $password );
    
    $mysql_hostname = '37.148.204.143';    
    $mysql_username = 'testdb81';
	$mysql_password = 'Shorence81!';
    $mysql_dbname = 'testdb81';

    try
    {
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare("SELECT user_id, username, password FROM users 
                    WHERE username = :username AND password = :password");

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        $stmt->execute();

        $user_id = $stmt->fetchColumn();

        if($user_id == false)
        {
                $message = 'Login Failed. <a href="login.php">Login</a>';
        }
        else
        {         
                $_SESSION['user_id'] = $user_id;
         
                $message = 'You are now logged in. <a href="logout.php">Logout</a>';
        }


    }
    catch(Exception $e)
    {
        $message = 'Unable to process your request."';
    }
}

?>
<?
if (isset($_SESSION['user_id'])){
include 'tasks_list.php';
}
else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login As User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

</head>
<body>

<div class="container">
  
	<div class="jumbotron">
    	<h1>Login As User</h1>
		<p>As a user I want to login in the system.</p> 
	</div>

	<div class="container">
		<h1 class="text-muted"><?php echo $message; ?></h1>
		<hr/>	   
	</div>  

</div>

</body>
</html>
<?
}
?>
