<?php 
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
<meta charset="utf-8">
<title>Start Here</title>

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
  <div class='container'>
        <div class='col-xs-12'>
      <div class='page-header'>
        <h1 class='text-center'>Politics is Cool</h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6 col-md-offset-3'>
      <div class="form-group">
        <!-- hardcode in the zipcode 60652 -->
        <label for="zipcode">Zipcode</label>
        <input type="text" class="form-control" id="zipcode">
      </div>
        <a  href="homeTest.php" id="makeZip" class="btn btn-success btn-md col-md-10 col-md-offset-1">Submit</a>
    </div>
  </div>  
</body>

<script>

var myButton = document.getElementById("makeZip");
myButton.addEventListener('click', sendZipcode);

function sendZipcode() {
  var zip = document.getElementById("zipcode");
  console.log(zip);
  sessionStorage.setItem('zipcode', zip.value);
  
}


</script>