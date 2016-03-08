var expect = chai.expect;

var SL_API_ROOT = 'http://openstates.org/api/v1/';
var REDDIT_API_ROOT = 'https://www.reddit.com/r/cs361projectb/search.json?q=&sort=top&restrict_sr=on&t=today';
var SL_API_KEY = '11815f3d1a374d038ab4b7d544b6cc09';

describe('Sunlight API Tests', function() {
  it('Valid Geolookup call returns HTTP 200 response', function(done) {
    this.timeout(5000);
    var lat = '40.748817'
    var lng = '-73.985428'
    var endpoint = SL_API_ROOT + 'legislators/geo/?lat=' + lat + '&long=' + lng;
    $.get(endpoint, {
      apikey: SL_API_KEY
    }).done(function(response, status, xhr) {
      expect(xhr.status).to.equal(200);
      done();
    });
  });
  it('Invalid Geolookup call returns HTTP 403 response', function(done) {
    var lat = '40.748817'
    var lng = '-73.985428'
    this.timeout(5000);
    var endpoint = SL_API_ROOT + 'legislators/geo/?lat=' + lat + '&long=' + lng;
    $.get(endpoint)
      .fail(function(response) {
        expect(response.status).to.equal(401);
        done();
      });
  });
  it('Geolookup call returns results in expected format', function(done) {
    var lat = '40.748817'
    var lng = '-73.985428'
    this.timeout(5000);
    var endpoint = SL_API_ROOT + 'legislators/geo/?lat=' + lat + '&long=' + lng;
    $.get(endpoint, {
        apikey: SL_API_KEY
      })
      .done(function(response, status, xhr) {
        expect(response[0].full_name).to.equal('Richard Gottfried');
        done();
      });
  });
});

describe('Reddit API Tests', function() {
  this.timeout(5000);
  it('Valid search API call returns HTTP 200 response', function(done) {
    var endpoint = REDDIT_API_ROOT;
    $.get(endpoint).done(function(response, status, xhr) {
      expect(xhr.status).to.equal(200);
      done();
    });
  });
  it('Search API call returns results in expected format', function(done) {
    var endpoint = REDDIT_API_ROOT;
    $.get(endpoint).done(function(response, status, xhr) {
      expect(response.kind).to.equal('Listing');
      $.each(response.data.children, function(i, e) {
        expect(e.kind).to.equal('t3');
      })
      done();
    });
  });
});

describe('New Issue Submission Tests', function() {

  it('Missing submission title returns error', function(done) {
    var endpoint = REDDIT_API_ROOT;
    var data = {
      category: 'Test',
      description: 'Test',
      official: 'TEST'
    }
    $.ajax({
      url: '../submit.php',
      type: 'POST',
      data: {
        data: data
      },
      success: function(response, status, xhr) {
        var response = JSON.parse(response)
        expect(response.messages[0]).to.equal('Title is required.');
        done();
      }
    })
  });

  it('Missing submission category returns error', function(done) {
    var endpoint = REDDIT_API_ROOT;
    var data = {
      title: 'Test',
      description: 'Test',
      official: 'TEST'
    }
    $.ajax({
      url: '../submit.php',
      type: 'POST',
      data: {
        data: data
      },
      success: function(response, status, xhr) {
        var response = JSON.parse(response)
        expect(response.messages[0]).to.equal('Category is required.');
        done();
      }
    })
  });

  it('Missing submission description returns error', function(done) {
    var endpoint = REDDIT_API_ROOT;
    var data = {
      title: 'Test',
      category: 'Test',
      official: 'TEST'
    }
    $.ajax({
      url: '../submit.php',
      type: 'POST',
      data: {
        data: data
      },
      success: function(response, status, xhr) {
        var response = JSON.parse(response)
        expect(response.messages[0]).to.equal('Description is required.');
        done();
      }
    })
  });

  it('Missing submission official returns error', function(done) {
    var endpoint = REDDIT_API_ROOT;
    var data = {
      title: 'Test',
      description: 'Test',
      category: 'TEST'
    }
    $.ajax({
      url: '../submit.php',
      type: 'POST',
      data: {
        data: data
      },
      success: function(response, status, xhr) {
        var response = JSON.parse(response)
        expect(response.messages[0]).to.equal('Official is required.');
        done();
      }
    })
  });

  it('Valid submission is posted to Reddit', function(done) {
    this.timeout(5000);
    var endpoint = REDDIT_API_ROOT;
    var data = {
      title: 'Automated Unit Test',
      description: 'Submitted as part of automated unit testing.',
      category: 'Unit Tests',
      official: 'TEST001'
    }
    $.ajax({
      url: '../submit.php',
      type: 'POST',
      data: {
        data: data
      },
      success: function(response, status, xhr) {
        expect(xhr.status).to.equal(200);
        done();
      }
    })
  });

});
