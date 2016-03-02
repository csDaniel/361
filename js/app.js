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
      $('#officialsTable').find('tr').remove().end();
      $.each(response, function(i, official) {
        var checkbox = '<td><input type="radio" name="official" value="' + official.id + '"></td>';
        var link = '<br/><a href="' + official.url + '" target="blank">Official Website »</a>';
        var data = official.full_name + ' (' + official.party.charAt(0) + '-' + official.state.toUpperCase() + ')';
        var name = '<td><span>' + data + link + '</span></td>';
        var img = '<td><img src="' + official.photo_url + '"/></td>';
        $('#officialsTable').append('<tr>' + checkbox + name + img + '</tr>')
      });
    });
  }

  $('#submitIssue').click(function(e) {
    e.preventDefault();
    var data = {
      title: $("input[name=title]").val(),
      category: $("select[name=category]").val(),
      description: $("textarea[name=description]").val(),
      official: $("input[name=official]").val()
    }
    if (data.title === null || data.category === null || data.description === null || data.official === null) {
      swal("Error", "Please make sure all form fields are completed.", "error");
      return;
    }
    $('#submitState').text('Submitting...');
    $('#submitIssue').prop('disabled', true);
    $.ajax({
      url: 'submit.php',
      type: 'POST',
      data: { data: data },
      success: function() {
        $('#submitState').text('Submit Issue');
        $('#submitIssue').prop('disabled', false);
      },
      statusCode: {
        200: function() {
          swal("Success", "Your issue was successfully created and posted for discussion.", "success");
        },
        400: function() {
          swal("Error", "There was an error creating your issue.", "error");
        },
        500: function() {
          swal("Error", "There was an error creating your issue.", "error");
        }
      }
    })
  })

});
