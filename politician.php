<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create a new issue</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
  </head>

<body>
  <?php include '_nav.php'; ?>
  <div class='container'>
    <div class='col-xs-12'>
      <div class='page-header'>
        <h1 id='pageTitle'></h1>
        <p>
        </p>
      </div>
    </div>
    <div class='col-xs-12'>
      <div id='official'></div>
    </div>
    <div class='col-xs-12 col-md-6'>
      <h1>Issues</h1>
      <form>
        <div class='form-group'>
          <label for='category'>Filter by issue category</label>
          <select class='form-control' id='filter' name='filterCategory' required>
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
      </form>
      <div id='issues'></div>
    </div>
    <div class='col-xs-12 col-md-6'>
      <h1>Submit a new issue</h1>
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
  <script src="js/politician.js"></script>
</body>

</html>