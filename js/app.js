$(document).ready(function() {

  var API_STATE_ROOT = 'http://openstates.org/api/v1/';
  var API_FED_ROOT = 'http://congress.api.sunlightfoundation.com/';
  var API_KEY = '11815f3d1a374d038ab4b7d544b6cc09';
  var lat;
  var lng;
  var x;

// Get data from sessions
 var getid = sessionStorage.getItem('id');
if (getid)
	 console.log(getid ); 
else getid = '-1';
console.log(getid);

// If user information, make API call immediately. Otherwise, display a form. 
 if (getid != '-1')
	  getLatLng();
 else {
	x = document.getElementById("addressForm");
	x.style.display = "";		
}


// Function to look up latitude and longitude information
document.getElementById('addressSubmit').addEventListener('click', function(event){
		
		console.log("hello there!");
		x = document.getElementById("addressForm");
		x.style.visibility = "hidden";
		
		// Get city and state from zip code
		var lreq = new XMLHttpRequest();
		var nreq = new XMLHttpRequest();
		var  openCageGeo = "5b1731898099d008e07be82f28583cc3";
		var lresponse;
		var city;
		var state;
		var zip = document.getElementById('zipCode').value;
		console.log("zip = " + zip);
		var streetN = document.getElementById('streetN').value;
		if (streetN == "Street Address" ||  zip == "5 Digit Zip Code" || streetN == "" || zip == "") {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
					function showPosition(position) {
						lat = position.coords.latitude;
						lng = position.coords.longitude;
						getFeds();
						getState();
					}
					x = document.getElementById("addressForm");
					x.parentNode.removeChild(x);
			} else {
				alert ("Please fill in all values");
				window.location = './home.php';
			}
			
		} 
		else {
			var url = 'http://ziptasticapi.com/' + zip;
			lreq.onload = getAPILatLong;
			lreq.open('GET', url, true);
			lreq.send(null);
			
			function getAPILatLong (){
				if (lreq.readyState === XMLHttpRequest.DONE) {
					lresponse = JSON.parse(lreq.responseText);
					city = lresponse.city;
					state = lresponse.state;
				} else {
						console.log("Error in network request: ", lreq.statusText);
				}
				
				nreq.onload = getOfficials;
				var placeName = streetN + '%2C+' + city + '%2C+' + state + '%2C+' + zip + '%2C+' + 'US';
				url = 'http://api.opencagedata.com/geocode/v1/json?q=' + placeName + '&key=' + openCageGeo;
				nreq.open('GET', url, true);
				nreq.send(null);
			}
				
			function getOfficials() {
				if (nreq.readyState === XMLHttpRequest.DONE ) {
					if( nreq.status >= 200 && nreq.status < 400 ) {
						lresponse = JSON.parse(nreq.responseText);
						lat = lresponse.results[0].geometry.lat;
						console.log(lat);
						lng = lresponse.results[0].geometry.lng;
						console.log(lng);
					} else {
						console.log("Error in network request: ", request.statusText);
					}
					x = document.getElementById("addressForm");
					x.parentNode.removeChild(x);
					getFeds();
					getState();
				
				}
			}
		}
});


  function getLatLng(){
	var req = new XMLHttpRequest();
	var url = 'getReqDB.php?InputType=getLatLng&id=' + getid;
	req.open('GET', url, false);
	req.send(null);
	var response = JSON.parse(req.response);
	lat = response.latitude;
	console.log(lat);
	lng = response.longitude;
	console.log(lng);
	getFeds();
	getState();
}

function getFeds() {
    $('#fed-official-group').hide();
    var endpoint = API_FED_ROOT + 'legislators/locate?latitude=' + lat + '&longitude=' + lng;
    $.get(endpoint, { 
	apikey: API_KEY
      }, function(response) {

	// Attach the header to the document
	var header = document.getElementById('header');
	var newheader = document.createElement('h1');
	var newtext = document.createTextNode("Get Started: Contact Your Reps")
	
	// Append all the elements to each other
	newheader.appendChild(newtext);
	header.appendChild(newheader);
	
	console.log(response);
        // clean out any previous politicians we fetched
        $('#fed-official-group').show();
        $('#fed-officials').find('div').remove().end();

        // iterate through politicians returned by API
        $.each(response.results, function(i, official) {
            // organize the data for this politician
            var data = {
              id: official.bioguide_id,
              name: official.first_name + " " + official.last_name,
              url: official.website,
              party: official.party,
              state: official.state,
              photo_url: 'https://theunitedstates.io/images/congress/original/' + official.bioguide_id + '.jpg' 
            };
		console.log(data);

            // create a new DOM element for each official
            var obj = $( '' +
              '<div class="media panel panel-default panel-official">' +
                '<div class="media-left">' +
                  '<img class="media-object" src="https://theunitedstates.io/images/congress/original/' + data.id + '.jpg"/>' +
                '</div>' +
                '<div class="media-body">' +
                  '<h4 class="media-heading">' + data.name + ' (' + data.party + '-' + data.state + ')</h4>' +
                  '<p><a href="' + data.url + '" target="blank">Official Website</a></p>' +
                  '<button class="btn btn-primary">View/Submit Issues</button>'+ 
                '</div>' +
              '</div>'
            );
            $('#fed-officials').append(obj)

            // make sure button sends official data to session storage
            $(obj).find('button').first().click(function() {
                sessionStorage.setItem('active', JSON.stringify({basic: data, raw: official}));
                window.location.replace('politician.php');
            })

        });

    });
  }

  function getState(){
    $('#state-official-group').hide();
    var endpoint = API_STATE_ROOT + 'legislators/geo/?lat=' + lat + '&long=' + lng;
    $.get(endpoint, {
        apikey: API_KEY
      }, function(response) {

        // clean out any previous politicians we fetched
        $('#state-official-group').show();
        $('#state-officials').find('div').remove().end();

        // iterate through politicians returned by API
        $.each(response, function(i, official) {

            // organize the data for this politician
            var data = {
              id: official.id,
              name: official.full_name,
              url: official.url,
              party: official.party.charAt(0),
              state: official.state.toUpperCase(),
              photo_url: official.photo_url
            };

            // create a new DOM element for each official
            var obj = $(''+
              '<div class="media panel panel-default panel-official">' +
                '<div class="media-left">' +
                  '<img class="media-object" src="' + data.photo_url + '"/>' +
                '</div>' +
                '<div class="media-body">' +
                  '<h4 class="media-heading">' + data.name + ' (' + data.party + '-' + data.state + ')</h4>' +
                  '<p><a href="' + data.url + '" target="blank">Official Website</a></p>' +
                  '<button class="btn btn-primary">View/Submit Issues</button>' +
                '</div>' +
              '</div>'
            );
            $('#state-officials').append(obj)

            // make sure button sends official data to session storage
            $(obj).find('button').first().click(function() {
                sessionStorage.setItem('active', JSON.stringify({basic: data, raw: official}));
                window.location.replace('politician.php');
            })

        });

    });
  }

});
