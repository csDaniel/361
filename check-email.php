<?php
	//echo "Request Processed";
	ini_set('display_errors', 'On');

	//login into database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hallbry-db","HnY9rGK4KVocyQJk","hallbry-db");
		//Turn on error reporting
	if(!$mysqli || $mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	if (!empty($_POST['email'])){
    $email = $mysqli->real_escape_string($_POST['email']);
    $query = "SELECT ID FROM Individual WHERE email = '{$email}' LIMIT 1;";
    $results = $mysqli->query($query);
    if($results->num_rows == 0){
        echo "true";  //good to register
    }
    else {
        echo "false"; //already registered
    }
	} else {
	    echo "That is an invalid email."; //invalid post var
	}
?>