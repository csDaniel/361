<?php 
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
<meta charset="utf-8">
<title>Reddit Forum Search</title>
</style>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<!-- START HTML -->
<body>
<div id="mainContent" class="container-fluid">
  <div class='col-xs-12'>
    <div class='page-header'>
      <h1 class='text-center'>Search Your Issues</h1>
      <p>
      </p>
    </div>
  </div>
	<div id="mainparent" class="col-md-offset-1 col-md-10">
    <div id="politicianInfo" class="col-md-offset-2 col-md-8">
      <span id="politicianThead" class='text-center'>
      </span>
      <table class="table">
        <tbody>
          <tr>
            <td class="col-md-3" id="politicianPic">
            </td>
            <td class="col-md-9">
              <table class="table table-condensed">
                <tbody id="politicianData">
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-md-offset-4 col-md-4"><br>
      <a href="addTest.php" class="btn btn-success btn-md col-xs-12" id="submitIssue">Create New Issue [doesnt work]</a>
    </div>
    <div class="col-md-offset-4 col-md-4"><br>
        <div class='form-group'>
          <label for='category'>Issue category</label>
          <select class='form-control' id="category">
            <option selected disabled>Select a category</option>
            <option value="None">Display All</option>
            <option value="Civil Rights">Civil Rights</option>
            <option value="Finance">Finance</option>
            <option value="Defense & Foreign Policy">Defense & Foreign Policy</option>
            <option value="Economy">Economy</option>
            <option value="Education">Education</option>
            <option value="Energy">Energy</option>
            <option value="Environment">Environment</option>
            <option value="Elections">Elections</option>
            <option value="Health">Health</option>
            <option value="Immigration">Immigration</option>
            <option value="Student Loans">Student Loans</option>
            <option value="Transportation">Transportation</option>
            <option value="Unions & Labor">Unions & Labor</option>
          </select>
        </div>
     <!-- <button id="clickButton" class="btn btn-warning">Search Issues</button> -->
    </div>
    <!-- <h2><p id="helloText" class="col-md-offset-4 col-md-4"></p></h2> -->
    <div id="displayer" class="col-xs-12 col-md-offset-1 col-md-10">
      <p></p>
    </div>
	</div>
</div>
<!-- END HTML -->



<!-- SCRIPT SECTION -->
<script> 

var sessionStuff = JSON.parse(sessionStorage.getItem('pdata'));
buildProfile(sessionStuff);
requestReddit(sessionStuff.leg_id);

//var myText = document.getElementById("helloText");
var myOption = document.getElementById("category");
myOption.addEventListener("change", refineResults, false);
//var addIssue = document.getElementById("submitIssue", makeNewIssue, false);


function refineResults() {
  var searchConstraintRaw = document.getElementById("category").selectedIndex;
  var searchConstraint = document.getElementsByTagName("option")[searchConstraintRaw].value;
  
  if (searchConstraint == "None") {
      loadRedditList(false);
    } else {
      console.log(searchConstraint);
      loadRedditList(true);
    }
}

function requestReddit(statement) {
  
  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  } else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
    
  xmlhttp.onreadystatechange = function () {
    //connection is good and status is okay;
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var response = xmlhttp.responseText;
      sessionStorage.setItem('redditInfo', response)
      loadRedditList(false);
        } // readystate
  } // xml
    
  var url = "https://www.reddit.com/r/cs361projectb/search.json?q=" + statement + "&sort=top&restrict_sr=on&t=year";
  xmlhttp.open("GET",url, true);
  xmlhttp.send(); 
}

// need reddit api info
function loadRedditList(refinedQuery) {
  var outputList = document.getElementById('displayer');
  // remove any children     
  while (outputList.firstChild) {
    outputList.removeChild(outputList.firstChild);
  }
  
	var redditObj = JSON.parse(sessionStorage.getItem('redditInfo'))  
  var obj = redditObj.data.children; 
  var resultCount = 0;

  var accordionPanel = document.createElement('div');
  accordionPanel.setAttribute('class', "panel-group");
  accordionPanel.setAttribute('id', "accordion");
  
  var searchConstraintRaw = document.getElementById('category').selectedIndex;
  var searchConstraint = document.getElementsByTagName("option")[searchConstraintRaw].value;
  
  for (i = 0; i < obj.length; i++) {
    
    var redditPanelOuter = document.createElement('div');
    redditPanelOuter.setAttribute('class', "panel panel-default"); 
     
    var redditPanelHeading = document.createElement('div');
    redditPanelHeading.setAttribute('class', "panel-heading");
    
    var redditPanelTitle = document.createElement('h3');
    redditPanelTitle.setAttribute('class', "panel-title");
    
    var collapseID = "collapse" + i;
    var redditPanelContentOuter = document.createElement('div');
    redditPanelContentOuter.setAttribute('class', "panel-collapse collapse")
    redditPanelContentOuter.setAttribute('id', collapseID);

    var redditPanelContentInner = document.createElement('div');
    redditPanelContentInner.setAttribute('class', "panel-body");

    // titleToke[2] will be thread title
    var collapseHeader = "#collapse" + i;    
    var titleRaw = obj[i].data.title;
    var titleToken = titleRaw.split("] ");
    redditPanelTitle.innerHTML = '<a data-toggle="collapse" data-parent="#accordion" href=' + collapseHeader + '>' + titleToken[2] + '</a>';

    var commentCount = document.createElement('span');
    commentCount.setAttribute('class', "badge col-xs-2 col-xs-offset-10");
    commentCount.innerHTML = '<br>' + obj[i].data.num_comments + ' comments';
    
    redditPanelHeading.appendChild(redditPanelTitle);
    redditPanelOuter.appendChild(redditPanelHeading);    
    
    redditPanelContentInner.innerHTML = '<a href=' + obj[i].data.url + '>' + obj[i].data.selftext + '</a>';
    redditPanelContentInner.appendChild(commentCount);    

    redditPanelContentOuter.appendChild(redditPanelContentInner);
    redditPanelOuter.appendChild(redditPanelContentOuter);
    
    if (refinedQuery == true) {
      if (titleRaw.indexOf(searchConstraint) > 0) {
        console.log("inside search constraint of refined place");
        accordionPanel.appendChild(redditPanelOuter);
        resultCount += 1;
      }
    } else {
        accordionPanel.appendChild(redditPanelOuter);
        resultCount += 1;
      }
	}
  outputList.appendChild(accordionPanel);
  myText.textContent = resultCount + " Results Found!";
}


function buildProfile(politician) {
  var pTitle = document.getElementById("politicianThead");
  var pPic = document.getElementById("politicianPic");
  var pTable = document.getElementById("politicianData");
  
  pTitle.innerHTML = "<h3>" + politician.full_name + "</h3>";
  pPic.innerHTML = "<img src=\"" + politician.photo_url + "\"/>";
  
  // build that table!
  
  // ID
  var pID = document.createElement('tr');
  pID.innerHTML = "<td>Legislative ID: " + politician.leg_id + "</td>";
  //var pID = "<tr> Legislative ID: " + politician.leg_id + "</tr>";
  pTable.appendChild(pID);
  // district
  var pDistrict = document.createElement('tr');
  pDistrict.innerHTML = "<td>Disctrict: " + politician.district + "</td>";
  pTable.appendChild(pDistrict);  
  // email
  var pEmail = document.createElement('tr');
  pEmail.innerHTML = "<td>Email: " + politician.email + "</td>";
  pTable.appendChild(pEmail);  
  // url
  var pURL = document.createElement('tr');
  pURL.innerHTML = "<td><a href=\"" + politician.url + "\">Official Website »</a></td>";
  pTable.appendChild(pURL);
  // roles?
  // politician.roles[i].committee
  
  var pCom = document.createElement('tr');
  pCom.innerHTML = "<td>Committee Membership: </br></td>";
  pTable.appendChild(pCom);
  for (i = 1; i < politician.roles.length; i++) {
    var pRoles = document.createElement('tr');
    pRoles.innerHTML = politician.roles[i].committee;
    pTable.appendChild(pRoles);
  }
 
  profileTable.appendChild(profileTBody);
  loc.appendChild(profileTable);  
}


//function makeNewIssue() {}

</script>
</body>
</html>
