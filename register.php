<?php


session_start();

$form_token = md5( uniqid('auth', true) );

$_SESSION['form_token'] = $form_token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register As User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
    	<h1>Register As User</h1>
		<p>As a user I want to register in the system.</p> 
	</div>

	<div class="container">
		<h1 class="text-muted">Enter username and password to register</h1>
		<hr/>
	   
		<form action="adduser_submit.php" method="post">

			<label id="dis" style="color:red"></label><br>

	    	<div class="form-group">
	    		<label for="userField">Username</label>
				<input type="user" class="form-control" placeholder="Enter username" id="user" name="username" required>
	    	</div>
	
	    	<div class="form-group">
	    		<label for="passwordField">Password</label>
				<input type="password" class="form-control" placeholder="Enter password" id="pass" name="password" required>
	    	</div>    	
			
			<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
	    	<button type="submit" class="btn btn-success" id="submit" name="submit">Submit</button>
			<a href="login.php">Login</a>
	    
		</form>

	</div>  

</div>

</body>
</html>
