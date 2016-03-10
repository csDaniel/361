	//add content when page loads
	$(document).ready(function() {
	      var API_ROOT = 'http://openstates.org/api/v1/';
	      var API_KEY = '11815f3d1a374d038ab4b7d544b6cc09';
	      var lat;
	      var lng;
	      var zip;
	      var city;
	      var state;
	      var address;
	      var username;
	      var password;
	      var email;
	      var fname;
	      var lname;


	      $('#createForm').validate({
	        //focuses on all invalid inputs
	        focusInvalid: false,
	        //default validation run on keyup and focusout, this sets to submit only
	        onkeyup: false,
	        onfocusout: false,
	        //default error elements is a <label>
	        errorElement: "div",
	        //put all errors in <div id="errors"> element
	        errorPlacement: function(error, element) {
	          error.appendTo("div#errors");
	        },
	        rules: {
	          username: {
	            required: true,
	            minlength: 5,
	            remote: {
	              url: "checkUsername.php",
	              type: "post"
	            }
	          },
	          email: {
	            required: true,
	            email: true,
	            remote: {
	              url: "checkEmail.php",
	              type: "post"
	            }
	          },
	          password: {
	            required: true,
	            minlength: 5
	          },
	          password_repeat: {
	            required: true,
	            equalTo: password,
	            minlength: 5
	          },
	          fname: {
	            required: true
	          },
	          lname: {
	            required: true
	          },
	          address: {
	            required: true
	          },
	          zipCode: {
	            required: true,
	            number: true,
	            rangelength: [3, 5]
	          }
	        },
	        messages: {
	          "username": {
	            required: "You must enter a username",
	            minlength: "Username must be at least 5 characters",
	            remote: "Username is already taken"
	          },
	          "email": {
	            required: "You must enter an email",
	            email: "You must enter a valid email address",
	            remote: "Email is already in use"
	          },
	          "password": {
	            required: "You must enter a password",
	            minlength: "Password must be at least 5 characters"
	          },
	          "password_repeat": {
	            required: "You must enter a password",
	            minlength: "Password must be at least 5 characters",
	            equalTo: "Passwords must match"
	          },
	          "fname": {
	            required: "You must enter your first name"
	          },
	          "lname": {
	            required: "You must enter your last name"
	          },
	          "address": {
	            required: "Your address is required to get your elected representatives"
	          },
	          "zipCode": {
	            required: "Your zip code is required to get your elected representatives",
	            number: "Zip code must contain digits only",
	            rangelength: "Valid zip code must contain 3 to 5 digits"
	          }
	        },
	        submitHandler: function(form) {
	          username = $('#username').val();
	          email = $('#email').val();
	          password = $('#password').val();
	          fname = $('#fname').val();
	          lname = $('#lname').val();
	          var $form = $(form);
	          $.when(getCityState().then(getLatLng)).then(function() {
	            request = $.ajax({
	              url: 'processRequest.php',
	              type: "POST",
	              cache: false,
	              data: {
	                InputType: 'CreateAccount',
	                username: username,
	                email: email,
	                password: password,
	                fname: fname,
	                lname: lname,
	                address: address,
	                city: city,
	                zipcode: zip,
	                state: state,
	                latitude: lat,
	                longitude: lng
	              },
	              dataType: "json",
	            });
	            request.done(function(response, textStatus, jqXHR) {
	              console.log("Submitted to DB");
	              window.location.href = "login.php";
	            });
	            request.error(function(jqxhr, textstatus, errorThrown) {
	              console.log("Error: " + errorThrown);
	              console.log("Status: " + textstatus);
	              console.dir(jqxhr);
	            });
	          });
	        }
	      });

	      function getCityState() {
	        zip = $('#zipCode').val();
	        return $.ajax({
	          url: 'http://ziptasticapi.com/' + zip,
	          type: "GET",
	          dataType: "json",
	          success: function(json) {
	            //console.log(json);
	            city = json.city;
	            state = json.state;
	          },
	          error: function(xhr, status, errorThrown) {
	            alert("Sorry, there was a problem!");
	            console.log("Error: " + errorThrown);
	            console.log("Status: " + status);
	            console.dir(xhr);
	          }
	        });
	      }

	      function getLatLng(resultFrom_getCityState) {
	        address = $('#address').val();
	        placeName = address + '%2C+' + city + '%2C+' + state + '%2C+' + zip + '%2C+' + 'US';
	        return $.ajax({
	          url: 'http://api.opencagedata.com/geocode/v1/json?q=' + placeName + '&key=c87e18939262cf20c812f32291c8e554',
	          type: "GET",
	          dataType: "json",
	          success: function(json) {
	            //console.log(json);
	            lat = json.results[0].geometry.lat;
	            lng = json.results[0].geometry.lng;
	          },
	          error: function(xhr, status, errorThrown) {
	            alert("Sorry, there was a problem!");
	            console.log("Error: " + errorThrown);
	            console.log("Status: " + status);
	            console.dir(xhr);
	          }
	        });
	      }

	      function submitToDB(result_GetLatLng) {
	        $.ajax({
	          url: 'processRequest.php',
	          type: "POST",
	          cache: false,
	          data: {
	            InputType: 'CreateAccount',
	            username: username,
	            email: email,
	            password: password,
	            fname: fname,
	            lname: lname,
	            address: address,
	            city: city,
	            zipcode: zip,
	            state: state,
	            latitude: lat,
	            longitude: lng
	          },
	          dataType: "json",
	          success: function(json) {
	            console.log("Submitted to DB");
	          },
	          error: function(xhr, status, errorThrown) {
	            console.log("Error: " + errorThrown);
	            console.log("Status: " + status);
	            console.dir(xhr);
	          }
	        });
	      }
