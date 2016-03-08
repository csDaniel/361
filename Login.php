<?php
?>
<!DOCTYPE html>
<!-- HTML5 Hello world by kirupa - http://www.kirupa.com/html5/getting_your_feet_wet_html5_pg1.htm -->
<html lang="en-us">
	<title>Building Trust in Our Leaders</title>
<head>
<meta charset="utf-8">
<title>Hello...</title>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/master.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="js/login.js"></script>


</head>

<body>
	<!--
<div id="mainContent">
<h1>Building Trust in Our Leaders</h1>

<form>
	<fieldset>
		<legend>Log In</legend>
		<p>User Name <input type = "text" id="username"></p> 
		<p>Password <input type = "password" id="password"></p> 
		<button id="loginButton" class="buttonStyle">Log In</button>
	</fieldset>
</form>

<p> Don't have an account? Create one here <a href="CreateAccount.html">Create Account</a></p>

</div>
-->
<?php include '_nav.php'; ?>
  <div class='container'>
    <div class='col-xs-12'>
      <div class='page-header'>
        <h1>Log In</h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6'>
      <div class='form-group'>
        <label for='username'>User Name:</label>
        <input type='text' id='username' class='form-control' name='username' />
        <label for='password'>Password:</label>
        <input type='password' id='password' class='form-control' name='password' />
        <button id="loginButton" class="buttonStyle">Log In</button>
      </div>
    </div>
  </div>

<div class='container'>
    <div class='col-xs-12'>
      <div class='page-header'>
        <h1>Register</h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6'>
      <div class='form-group'>
        <p> Don't have an account: <a href="CreateAccount.php">Create Account</a></p>
      </div>
    </div>
  </div>


</body>
</html>
