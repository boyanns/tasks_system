<?php
session_start();

if(!isset( $_POST['username'], $_POST['password'], $_POST['form_token']))
{
    $message = 'Please enter a valid username and password';
}
elseif( $_POST['form_token'] != $_SESSION['form_token'])
{
    $message = 'Invalid form submission';
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

        $stmt = $dbh->prepare("INSERT INTO users (username, password ) VALUES (:username, :password )");

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        $stmt->execute();

        unset( $_SESSION['form_token'] );

        $message = 'New user added. <a href="login.php">Login</a>';
    }
    catch(Exception $e)
    {
        if( $e->getCode() == 23000)
        {
            $message = 'Username already exists';
        }
        else
        {    
            $message = 'We are unable to process your request. Please try again later"';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login/Logout As User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$('#submit').click(function(){
var username=$('#user').val();
var password=$('#pass').val();

if(username=="")
{
$('#dis').slideDown().html("<span>Please type Username</span>");
return false;
}
if(password=="")
{
$('#dis').slideDown().html('<span id="error">Please type Password</span>');
return false;
}
});
});
</script>

</head>
<body>

<div class="container">
  
	<div class="jumbotron">
    	<h1>Login/Logout As User</h1>
		<p>As a user I want to login and logout from the system.</p> 
	</div>
	<div class="container">
		<h1 class="text-muted"><?php echo $message; ?></h1>
		<hr/>	   	
	</div>  

</div>

</body>
</html>
