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

        // clean out any previous politicians we fetched
        $('#official-group').show();
        $('#officials').find('div').remove().end();

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
            var obj = $('\
              <div class="media panel panel-default panel-official">\
                <div class="media-left">\
                  <img class="media-object" src="' + data.photo_url + '"/>\
                </div>\
                <div class="media-body">\
                  <h4 class="media-heading">' + data.name + ' (' + data.party + '-' + data.state + ')</h4>\
                  <p><a href="' + data.url + '" target="blank">Official Website</a></p>\
                  <button class="btn btn-primary">View/Submit Issues</button>\
                </div>\
              </div>'
            );
            $('#officials').append(obj)

            // make sure button sends official data to session storage
            $(obj).find('button').first().click(function() {
                sessionStorage.setItem('active', JSON.stringify({basic: data, raw: official}));
                window.location.replace('politician.php');
            })

        });

    });
}


});
