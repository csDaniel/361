<?php
	//echo "Request Processed";
	ini_set('display_errors', 'On');
	//get request type
	
	$result= $_POST['InputType'];

	
	//login into database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hallbry-db","HnY9rGK4KVocyQJk","hallbry-db");
		//Turn on error reporting
	if(!$mysqli || $mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	// *****************************************
	// Account Creation
	// ******************************************
	if ($result === "CreateAccount"){
		
		if(!($stmt = $mysqli->prepare("INSERT INTO Individual (username, password, fname, lname, address, city, zipcode, state, latitude, longitude) VALUES (?, ?, ?,?,?,?,?,?, ?, ?);"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
		}
		if(!($stmt->bind_param("ssssssisss", $_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['city'], $_POST['zipcode'], $_POST['state'], $_POST['latitude'], $_POST['longitude']))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}
		//failed to execute
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error. ". Username variable: " . $_POST['username'];
		} 
		//send back a 1 for success
		else{
			
			if(!($stmt = $mysqli->prepare("SELECT id FROM `Individual` WHERE username = ? && password = ?"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
			}
			if(!($stmt->bind_param("ss", $_POST['username'], $_POST['password']))){
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
			if($stmt->num_rows === 1){
				$stmt->bind_result($id);
				$stmt->fetch();
				echo $id;
				
			}
			else{
				echo "0";
			}
				
		
			
			
		}
		$stmt->close();
	}
	
	// *****************************************
	// Account Login
	// ******************************************
	else if($result === "Login"){
		
		
		if(!($stmt = $mysqli->prepare("SELECT * FROM `Individual` WHERE username = ? && password = ?"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
		}
		
		if(!($stmt->bind_param("ss", $_POST['username'], $_POST['password']))){
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
		if($stmt->num_rows === 1){

			if(!($stmt = $mysqli->prepare("SELECT id FROM `Individual` WHERE username = ? && password = ?"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
			}
			if(!($stmt->bind_param("ss", $_POST['username'], $_POST['password']))){
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
			if($stmt->num_rows === 1){
				$stmt->bind_result($id);
				$stmt->fetch();
				echo $id;
				
			}
			else{
				echo "0";
			}
			
		}
		else{
			echo "0";
		}
		
			 
		
		
		$stmt->close();	
		
		
	}
	
	// *****************************************
	// Add Politician to Indiv-Po
	// ******************************************
	else if($result === "AddPolitician"){
		echo "adding politician";
		
		// Insert 
		if(!($stmt = $mysqli->prepare("INSERT INTO `Indiv_Poli` (id, pid, localPol) VALUES (?, ?, ?);"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
		}
		
		// execute local1id
		$id = $_POST['userid'];
		$localPol = 1;
		if(!($stmt->bind_param("isi", $id, $pid, $localPol ))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}	
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error. ". Local Rep1: " . $_POST['local1id'];
		} 
		
		//execute local2id
		$pid = $_POST['local2id'];
		if(!($stmt->bind_param("isi", $id, $pid, $localPol ))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}	
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error. ". Local Rep2: " . $_POST['loca12id'];
		} 
		
		// execute repid
		$localPol = 0;
		$pid = $_POST['repid'];
		if(!($stmt->bind_param("isi", $id, $pid, $localPol ))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}	
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error. ". Federal Rep: " . $_POST['repid'];
		} 
		
		// execute sen1id
		$pid = $_POST['sen1id'];
		if(!($stmt->bind_param("isi", $id, $pid, $localPol ))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}	
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error. ". Senator1: " . $_POST['sen1id'];
		} 
		
		// execute sen2id
		$pid = $_POST['sen2id'];
		if(!($stmt->bind_param("isi", $id, $pid, $localPol ))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}	
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error. ". Senator2: " . $_POST['sen2id'];
		} 
				
		$stmt->close();
		
	}
	
	else if($result === "FindPolitician"){
		
		if(!($stmt = $mysqli->prepare("SELECT pid FROM `Indiv_Poli` WHERE id = ?"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;	
		}
		if(!($stmt->bind_param("i", $_POST['userid']))){
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
		
		// If there are any politicians, there, print them all
		if($stmt->num_rows === 1){
				while($stmt->fetch()){
					$stmt->bind_result($pid);
					echo $pid;
				}
				
		}
		$stmt->close();
		
	}
	
	// Otherwise, it didn't catch any of the input types 
	else{
		echo "error";
	}
	






?>