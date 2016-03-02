<?php
  ini_set('display_errors', 'On');
  error_reporting(E_ALL | E_STRICT);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create a new issue</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
</head>

<body>
  <div class='container'>
    <div class='col-xs-12'>
      <div class='page-header'>
        <h1 class='text-center'>Create a new issue</h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12 col-md-6 col-md-offset-3'>
      <form id='newIssue'>
        <div class='form-group'>
          <label for='title'>Issue title</label>
          <input type='text' placeholder='e.g. Idea for creating new jobs' name='title' class='form-control' required/>
        </div>
        <div class='form-group'>
          <label for='category'>Issue category</label>
          <select class='form-control' name='category' required>
            <option selected disabled>Select a category</option>
            <option>Civil Rights</option>
            <option>Finance</option>
            <option>Defense & Foreign Policy</option>
            <option>Economy</option>
            <option>Education</option>
            <option>Energy</option>
            <option>Environment</option>
            <option>Elections</option>
            <option>Health</option>
            <option>Immigration</option>
            <option>Student Loans</option>
            <option>Transportation</option>
            <option>Unions & Labor</option>
          </select>
        </div>
        <div class='form-group'>
          <label for='category'>Issue description</label>
          <textarea class='form-control' name='description' placeholder='i.e. Describe the issue you are concerned about, including as much relevant detail as possible.' rows=10 required></textarea>
        </div>
        <div class='form-group'>
          <label for='geocomplete'>Street address (find your reps)</label>
          <input id='geocomplete' class='form-control' name='location' />
          <div class='geodata'>
            <input name="lat" id='lat' type="hidden" value="">
            <input name="lng" id='lng' type="hidden" value="">
          </div>
        </div>
        <div class='form-group' id='official-group'>
          <label for='officials'>Address to an official/representative</label>
          <table class='table table-bordered' id="officialsTable">
            <tbody>
            </tbody>
          </table>
        </div>
        <div class='form-group'>
          <button type='submit' id='submitIssue' class='btn btn-success btn-lg btn-block'>
            <span id='submitState'>Submit Issue</span>
          </button>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js" charset="utf-8"></script>
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="js/jquery.geocomplete.min.js"></script>
  <script src="js/app.js"></script>
</body>

</html>
