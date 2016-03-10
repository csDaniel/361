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
  <script src="js/jquery.geocomplete.min.js"></script>
  <script src="js/app.js"></script>

</head>
<body>
  <?php include '_nav.php'; ?>


  <div class='container'>
    <div class='col-xs-12'>
      <div class='page-header' id='header'>

	<div class="container" id= "addressForm" style="display:none">
		<h1>Who are my political representatives?</h1>
		<p> To find your state and federal legislative representatives, just enter your address and click the "Go" button. </p>
		<p> If you just want us to use your current location, just press "Go" without entering your address, and then press "allow geocoding" in any pop-up from your browser. </p>
    <div class="row">
    <div class="col-xs-12 col-md-6">
		<form>
	  <fieldset>
		<label>Enter your Address:</label>
    <div class="form-group">
		<input type="text" class="form-control"  value="Street Address" onfocus="if(this.value==&#39;Street Address&#39;) this.value=&#39;&#39;;" name="streetN" id="streetN" style="font-style: normal;">
  </div>
  <div class="form-group">
		<input type="text" class="form-control" value="5 Digit Zip Code" onfocus="if(this.value==&#39;5 Digit Zip Code&#39;) this.value=&#39;&#39;;" name="zipCode" id="zipCode" style="font-style: normal;">
  </div>
		<p><a class="btn btn-primary btn-lg" id="addressSubmit" role="button">Go »</a></p>
	  </fieldset>
	</form>
</div>
</div>
	</div>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6'>
      <div class='form-group' id='fed-official-group'>
        <div class="list-group" id="fed-officials">
        </div>
      </div>
    </div>
    <div class='col-xs-12 col-md-6'>
      <div class='form-group' id='state-official-group'>
        <div class="list-group" id="state-officials">
        </div>
      </div>
    </div>
  </div>
</body>
</html>
