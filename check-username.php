<?php
	ini_set('display_errors', 'On');

	//login into database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hallbry-db","HnY9rGK4KVocyQJk","hallbry-db");
		//Turn on error reporting
	if(!$mysqli || $mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

	if (!empty($_POST['username'])){
    $username = $mysqli->real_escape_string($_POST['username']);
    $query = "SELECT ID FROM Individual WHERE username = '{$username}' LIMIT 1;";
    $results = $mysqli->query($query);
    if($results->num_rows == 0){
        echo "true";  //good to register
    }
    else {
        echo "false"; //already registered
    }
	} else {
	    echo "That is an invalid username"; //invalid post var
	}
/*
	if(!($stmt = $mysqli->prepare("SELECT * FROM `Individual` WHERE username = ?"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
	}
	
	if(!($stmt->bind_param("s", $_POST['username']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	//failed to execute
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} 
	
	//prepare results
	if(!$stmt->store_result()){
		echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	if($stmt->num_rows ==== 1){
		echo 'false';
	} else if ($stmt->num_rows ==== 0)) {
		echo 'true';
	} else {
		echo 'false';
	}
	*/
/*
if(isset($_POST['username'])) {
		$username = $_POST['username'];
		$query = $mysqli->prepare("SELECT * FROM 'Individual' WHERE username = '$username'");
	  $query->execute();
		$rows = $query->fetchAll();
		$total_rows = count($rows);
	    if( $total_rows > 0 ){
	        echo 'false';
	    } else {
	        echo 'true';
	    }
  }
  */
?>