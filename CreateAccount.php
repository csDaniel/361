<?php
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
<meta charset="utf-8">
<title>Building Trust in Our Leaders</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/master.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<script src="js/jquery.geocomplete.min.js"></script>
<script src='js/redirect.js'></script>
<script src="js/createAccount.js"></script>


</head>

<body>

<?php include '_nav.php'; ?>
  <div class='container'>
    <div class='col-xs-12'>
      <div class='page-header'>
        <h1>Create Account</h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6'>
    	<form class="form" id="createForm" method="POST" action="processRequest.php">
	    	<div class="form-group" id="errors"></div>
	      <div class='form-group'>
	        <label for='username'>User Name:</label>
	        <input type='text' id='username' class='form-control' name='username' placeholder='Username'/>
	      </div>
	      <div class='form-group'>
	        <label for='email'>Email:</label>
	        <input type='email' id='email' class='form-control' name='email' placeholder='email@email.com'/>
	      </div>
	      <div class='form-group'>
	        <label for='password'>Password:</label>
	        <input type='password' id='password' class='form-control' name='password' placeholder='Password'/>
	      </div>
	      <div class='form-group'>
	        <label for='password_repeat'>Confirm Password:</label>
	        <input type='password' id='password_repeat' class='form-control' name='password_repeat' placeholder='Password'/>
	      </div>
	      <div class='form-group'>
	        <label for='fname'>First Name:</label>
	        <input type='text' id='fname' class='form-control' name='fname' placeholder='First Name'>
	      </div>
	      <div class='form-group'>
	        <label for='lname'>Last Name:</label>
	        <input type='text' id='lname' class='form-control' name='lname' placeholder='Last Name'/>
	      </div>
	      <div class='form-group'>
	        <label for="address">Street Address</label>
	        <input type='text' id='address' class='form-control' name='address' placeholder='1234 Example St'/>
	       </div>
	       <div class='form-group'>
	        <label for="zipCode">Zip Code</label>
	        <input type='text' id='zipCode' class='form-control' name='zipCode' placeholder='Zip Code'/>
	       </div>
	       <div class='form-group'>
	        <button type='submit' class="btn btn-primary">Create My Account</button>
	      </div>
	    </div>
  	</form>
  </div>

</body>
</html>
