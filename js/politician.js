$(document).ready(function() {
  function buildPolitician() {
    $('#official').find('div').remove().end();
    // load session data
    var active = JSON.parse(sessionStorage.getItem('active'));
    var data = active.basic;
    var raw = active.raw;
    // set page title to pol's name
    $('#pageTitle').text(data.name + ' (' + data.party + '-' + data.state + ')');
    // create DOM elements for commitee roles
    var roles = [];
    $.each(raw.roles, function(i, e) {
      if (e.committee) {
        roles.push($('<p>' + e.committee + '</p>'));
      }
    })
    // create DOM element for pol info
    var obj = $('\
      <div class="media panel panel-default panel-official">\
        <div class="media-left">\
          <img class="media-object" src="' + data.photo_url + '"/>\
        </div>\
        <div class="media-body">\
          <div class="row">\
            <div class="col-xs-12 col-md-3">\
            <h4 class="media-heading">' + data.name + ' (' + data.party + '-' + data.state + ')</h4>\
            <p><a href="' + data.url + '" target="blank">Official Website</a></p>\
            <p>Legislative ID: ' + data.id + '</p>\
            <p>District: ' + raw.district + '</p>\
            </div>\
            <div class="col-xs-12 col-md-3">\
              <div class="roles"><h4 class="media-heading">Committee Membership</h4></div>\
            </div>\
          </div>\
        </div>\
      </div>'
    );
    $('#official').append(obj)
    $(obj).find('.roles').first().append(roles);
  }

  function fetchIssues(search) {

    $('#issues').find('div').remove().end();
    $('#issues').append('<div class="alert alert-info">Loading issues...</div>');

    if (search === undefined) {
      search = '';
    }

    var id = JSON.parse(sessionStorage.getItem('active')).basic.id;

    var API_ROOT = 'https://www.reddit.com/r/cs361projectb/search.json';
    $.get(API_ROOT + "?q=" + search + "&sort=top&restrict_sr=on&t=year", function(resp) {
      $('#issues').find('div').remove().end();
      var issues = [];
      $.each(resp.data.children, function(i, e) {
        var title_id = e.data.title.match(/[^[\]]+(?=])/g)[0];
        if (title_id === id) {
          var issue = $('\
          <div>\
            <span class="badge">' + e.data.score + '</span>\
            <span><a href="' + e.data.url + '" target="blank">' + e.data.title + '</a></span>\
          <div>\
          ')
          issues.push(issue);
        }
      });
      if (issues.length === 0) {
        if (search === '') {
          issues.push($('<div class="alert alert-danger">No issues found for this politician. Submit the first one now!</div>'));
        } else {
          issues.push($('<div class="alert alert-danger">No issues found for this politician in the <b>' + search + '</b> category.</div>'));
        }

      }
      $('#issues').append(issues);
    });
  }

  $('#submitIssue').click(function(e) {
    e.preventDefault();
    var id = JSON.parse(sessionStorage.getItem('active')).basic.id;
    var data = {
      title: $("#newIssue input[name=title]").val(),
      category: $("#newIssue select[name=category]").val(),
      description: $("#newIssue textarea[name=description]").val(),
      official: id
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
      data: {
        data: data
      },
      success: function() {
        $('#submitState').text('Submit Issue');
        $('#submitIssue').prop('disabled', false);
        fetchIssues();
      },
      statusCode: {
        200: function() {
          swal("Success", "Your issue was successfully created and posted for discussion. It may take a few minutes for your issue to be live on Reddit.", "success");
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

  $('#filter').change(function() {
    fetchIssues($(this).val().toLowerCase())
  })

  buildPolitician();
  fetchIssues();

});
