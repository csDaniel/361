<?php
	//echo "Request Processed";
	ini_set('display_errors', 'On');
	//get request type
	
	$result= $_GET['InputType'];

	
	//login into database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hallbry-db","HnY9rGK4KVocyQJk","hallbry-db");
		//Turn on error reporting
	if(!$mysqli || $mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

	if ($result === "getLatLng"){
		
		if(!($stmt = $mysqli->prepare("SELECT latitude, longitude FROM Individual WHERE id = ?"))){
				echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
		}

		if(!($stmt->bind_param("i", $_GET['id']))){
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
				
		// If there is latitude and longitude, print them
		if($stmt->num_rows === 1){
				while($stmt->fetch()){
					$stmt->bind_result($latitude, $longitude);
						echo $latitude;
						echo $longitude;
				}
						
		}
		$stmt->close();
				
	}		
	// Otherwise, it didn't catch any of the input types 
	else{
		echo "error";
	}

?>