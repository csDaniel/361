//add content when page loads
document.addEventListener('DOMContentLoaded', bindButtons);
// bind the button

function bindButtons(){
	//gather parameters into json object
	document.getElementById("loginButton").addEventListener('click',function(event){
		var req = new XMLHttpRequest();
		var stateReq = new XMLHttpRequest();
		var fedReq = new XMLHttpRequest();
		var payload = {username:null, password:null, InputType:null}
		payload.username= document.getElementById("username").value;
		payload.password= document.getElementById("password").value;
		payload.InputType= "Login";
		
	
		//validation user has filled in fields
		var fillStatus =0; 
		
		if(payload.username == ""){
			alert("Please Fill out Username");
			fillStatus=1;
		}
		
		else if(payload.password == ""){
			alert("Please Fill out Password");
			fillStatus=1;
		}
		
		//send request if status is 0
		if(fillStatus ==0){
			
			req.open('POST', 'ProcessRequest.php', false);
			req.setRequestHeader('Content-Type', 'application/json');
			req.send(JSON.stringify(payload));
			var response = req.responseText; 
			if(response == 0){
				alert("Your password or username was incorrect.");
			}
			else{
				alert("Your login was a success");
				var id = response.id;
				console.log(id);
				
				// Ask database for all the politician ids
				var newReq = new XMLHttpRequest();
				var payloadLogin = {userid:id, InputType:"FindPolitician"};
				newReq.open('POST', 'ProcessRequest.php', false);
				newReq.setRequestHeader('Content-Type', 'application/json');
				newReq.send(JSON.stringify(payloadLogin));
				var newResponse = newReq.responseText;
				console.log("UserID is: " + newResponse);
				
				//getting rep info via api call
				if (id == 0) {
					/*
					function getLatLng(){
						//Get latitude and longitude from DB
							$.ajax({
								url: 'getReqDB.php',
								type: "GET",
								data: { InputType: 'getLatLng', id: id},
								dataType: "json",
								success: function( json ) {
										console.log(json);
										submitLatLng(json);
								},
								error: function( xhr, status, errorThrown ) {
									alert( "Sorry, there was a problem!" );
				        			console.log( "Error: " + errorThrown );
						        	console.log( "Status: " + status );
				        			console.dir( xhr );
								},
								// Code to run regardless of success or failure
				    			//complete: function( xhr, status ) {
				        	//alert( "The request is complete!" );
				    		//}
						});
					}*/
					/*
					function postReps(json) {
						var lat = json.latitude;
						var lng = json.longitude;
						//Get Federal legislators by address( longitude and latitude for API call to Sunlight Foundation)
						$.ajax({
								url: 'http://congress.api.sunlightfoundation.com/legislators/locate?latitude=' + lat + '&longitude=' + lng + '&apikey=7efed6018b11418a9ffdf9a868b9a845';
								type: "GET",
								dataType: "json",
								success: function( json ) {
										console.log(json);
										submitFed(json);
								},
								error: function( xhr, status, errorThrown ) {
									alert( "Sorry, there was a problem!" );
				        			console.log( "Error: " + errorThrown );
						        	console.log( "Status: " + status );
				        			console.dir( xhr );
								},
								// Code to run regardless of success or failure
				    			complete: function( xhr, status ) {
				        	//alert( "The request is complete!" );
				    		}
						});

						//Get local officials using Jquery AJAX call to Sunlight Open States API
						$.ajax({
								url: "http://openstates.org/api/v1/legislators/geo/?lat=" + lat + "&long=" + lng + "&apikey=7efed6018b11418a9ffdf9a868b9a845",
								type: "GET",
								dataType: "json",
								success: function( json ) {
										console.log(json);
										submitState(json);
								},
								error: function( xhr, status, errorThrown ) {
									alert( "Sorry, there was a problem!" );
				        			console.log( "Error: " + errorThrown );
						        	console.log( "Status: " + status );
				        			console.dir( xhr );
								},
								// Code to run regardless of success or failure
				    			complete: function( xhr, status ) {
				        	//alert( "The request is complete!" );
				    		}
						});
					}*/
					window.location = "http://web.engr.oregonstate.edu/~jinksw/361/home.php";
				}
				//response was found, rep info is in db
				else {
					window.location = "http://web.engr.oregonstate.edu/~jinksw/361/home.php";
					//alert(newResponse);
					//console.log(newResponse);
					
				}
			/*
				function submitState(result_PostState){
					var repid = result_PostState.
					$.ajax({
						url: 'ProcessRequest.php',
						type: "POST",
						cache: false,
						data: { InputType: 'AddPolitician', username: username, email: email, password: password, fname: fname, lname: lname, address: address, city: city, zipcode: zip, state: state, latitude: lat, longitude: lng},
						dataType: "json",
						success: function( json ) {
							console.log("Submitted to DB");
						},
						error: function( xhr, status, errorThrown ) {
							console.log( "Error: " + errorThrown );
			    		console.log( "Status: " + status );
							console.dir( xhr );
						}
					});
				}

				function submitFed(result_PostFed){
					var repid = result_PostFed.
					$.ajax({
						url: 'ProcessRequest.php',
						type: "POST",
						cache: false,
						data: { InputType: 'AddPolitician', username: username, email: email, password: password, fname: fname, lname: lname, address: address, city: city, zipcode: zip, state: state, latitude: lat, longitude: lng},
						dataType: "json",
						success: function( json ) {
							console.log("Submitted to DB");
						},
						error: function( xhr, status, errorThrown ) {
							console.log( "Error: " + errorThrown );
			    		console.log( "Status: " + status );
							console.dir( xhr );
						}
					});
				}
				
				var payloadForm = {sen1id:null, sen2id:null, repid: null, local1id:null, local2id:null, userid:null, InputType:null};
				
	
				var homepage = "home.php";
				
				// Send that in a post request form to the homepage 
				
				var form = document.createElement("form");
				form.setAttribute("id", "latlngToHome")
				form.setAttribute("method", "post");
				form.setAttribute("action", homepage);
				*/
			}	
		}
		else{
			alert ("You Suck");
		}
	event.preventDefault();	
	});
}



function goToHomePage() {
	window.location = '/home.php';
}
	
	
	
	
	