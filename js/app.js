$(document).ready(function() {

  var API_STATE_ROOT = 'http://openstates.org/api/v1/';
  var API_FED_ROOT = 'http://congress.api.sunlightfoundation.com/';
  var API_KEY = '11815f3d1a374d038ab4b7d544b6cc09';
  var lat;
  var lng;
 
	// Get user id from get request 
	var getid = "";
	var place  = window.location.href;
	i = place.length-1;
	while (place[i] != '='){
		var temp = getid;
		getid  = place[i] + temp;
		i = i-1;
	}
	console.log(getid ); 

  getLatLng();


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
