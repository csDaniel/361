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
      <div class='page-header'>
        <h1>Get Started: Find Your Reps</h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6'>
      <div class='form-group'>
        <label for='geocomplete'>Enter your street address:</label>
        <input id='geocomplete' class='form-control' name='location' />
        <div class='geodata'>
          <input name="lat" id='lat' type="hidden" value="">
          <input name="lng" id='lng' type="hidden" value="">
        </div>
      </div>
      <div class='form-group' id='official-group'>
        <div class="list-group" id="officials">
        </div>
      </div>
    </div>
  </div>
</body>
</html>
