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
		<h1 class="text-muted">User login</h1>
		<hr/>
	   
		<form method="post" action="login_submit.php">

			<label id="dis" style="color:red"></label><br>

	    	<div class="form-group">
	    		<label for="userField">Username</label>
				<input type="user" class="form-control" placeholder="Enter username" id="user" name="username" required>
	    	</div>
	
	    	<div class="form-group">
	    		<label for="passwordField">Password</label>
				<input type="password" class="form-control" placeholder="Enter password" id="pass" name="password" required>
	    	</div>    	
	
	    	<button type="submit" class="btn btn-success" id="submit" name="submit">Login</button>
			<a href="register.php">Register</a>
	    
		</form>

	</div>  

</div>

</body>
</html>
