$(document).ready(function() {

  var API_STATE_ROOT = 'http://openstates.org/api/v1/';
  var API_FED_ROOT = 'http://congress.api.sunlightfoundation.com/';
  var API_KEY = '11815f3d1a374d038ab4b7d544b6cc09';
  var lat;
  var lng;

  getLatLng();

  function getLatLng(){
    //Get latitude and longitude from DB
      $.ajax({
        url: 'getReqDB.php',
        type: "GET",
        data: { InputType: 'getLatLng', id: id},
        dataType: "json",
        success: function( json ) {
            console.log(json);
            lat = json.latitude;
            lng = json.longitude;
            getFeds();
            getState();
        },
        error: function( xhr, status, errorThrown ) {
          alert( "Sorry, there was a problem!" );
              console.log( "Error: " + errorThrown );
              console.log( "Status: " + status );
              console.dir( xhr );
        }
        // Code to run regardless of success or failure
          //complete: function( xhr, status ) {
          //alert( "The request is complete!" );
        //}
    });
  }

function getFeds() {
    $('#fed-official-group').hide();
    var endpoint = API_FED_ROOT + 'legislators/locate?latitude=' + lat + '&long=' + lng;
    $.get(endpoint, {
        apikey: API_KEY
      }, function(response) {

        // clean out any previous politicians we fetched
        $('#fed-official-group').show();
        $('#fed-officials').find('div').remove().end();

        // iterate through politicians returned by API
        $.each(response, function(i, official) {

            // organize the data for this politician
            var data = {
              id: official.bioguide_id,
              name: official.first_name + " " + official.last_name,
              url: official.website,
              party: official.party.charAt(0),
              state: official.state.toUpperCase()
              //photo_url: official.photo_url   //No pics for feds from Congress API
            };

            // create a new DOM element for each official
            var obj = $( '' +
              '<div class="media panel panel-default panel-official">' +
                '<div class="media-left">' +
                  '<img class="media-object" src="' +/*+ data.photo_url + */'"/>' +
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
    var endpoint = API_ROOT + 'legislators/geo/?lat=' + lat + '&long=' + lng;
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
