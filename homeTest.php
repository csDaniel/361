<?php 
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
<meta charset="utf-8">
<title>Politics is Cool</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="js/jquery.geocomplete.min.js"></script>
  
</head>
<body>
  <div class='container'>
        <div class='col-xs-12'>
      <div class='page-header'>
        <h1 class='text-center'>Home Page!</h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6 col-md-offset-3'>
      <p>Your Zipcode is <span id="zcode"></span></p>
      <div class='form-group'>
        <label for='geocomplete'>Street address (find your reps)</label>
        <input id='geocomplete' class='form-control' name='location' />
        <div class='geodata'>
          <input name="lat" id='lat' type="hidden" value="">
          <input name="lng" id='lng' type="hidden" value="">
        </div>
      </div>
      <div class='form-group' id='official-group'>
        <div class="list-group" id="officialsTable">
        </div>
      </div>
    </div>
  </div>  
</body>

<script>
  var zipHTML = document.getElementById("zcode");
  var zipcode = sessionStorage.getItem('zipcode');
  //console.log(zipcode);
  zipHTML.innerHTML = zipcode;
  var discussionLookup = "\"discussionLookup.html\"";
  
  
$(document).ready(function() {

  var API_ROOT = 'http://openstates.org/api/v1/';
  var API_KEY = '11815f3d1a374d038ab4b7d544b6cc09';

  $('#geocomplete').geocomplete({
    details: '.geodata'
  }).bind("geocode:result", function(event, result) {
    geoLookup($('#lat').val(), $('#lng').val());
  });

  function geoLookup(lat, lng) {
    $('#official-group').hide();
    var endpoint = API_ROOT + 'legislators/geo/?lat=' + lat + '&long=' + lng;
    $.get(endpoint, {
      apikey: API_KEY
    }, function(response) {
      $('#official-group').show();

      $.each(response, function(i, official) {
        var listItem = document.createElement('a');
        listItem.setAttribute('id', 'politician');
        
        var link = '<span href="' + official.url + '" target="blank">Official Website »</span>';
        var politicalID = official.leg_id;
        var data = official.full_name + ' (' + official.party.charAt(0) + '-' + official.state.toUpperCase() + ')';
        var name = '<span>' + data + link + '</span>';
        var img = '<img src="' + official.photo_url + '"/>';
        
        listItem.setAttribute('href', "#");
        listItem.setAttribute('class', "list-group-item");       
        listItem.innerHTML = img + '<h3 id="' + politicalID + '">' + politicalID + "<br>" + name + '</h3>';
        listItem.addEventListener('click', function() {
          var newSearch = this;
          storeSend(newSearch);
          sessionStorage.setItem('pdata', JSON.stringify(official));

        });
        $('#officialsTable').append(listItem);        
      });
    });
  };
  
  // add dynamic link to store shit and send it.
  function storeSend(politicianInfo) {
    
    sessionStorage.setItem('politician', politicianInfo.innerHTML);

    location.assign("discussionLookup.php");

  }
  
});

</script>