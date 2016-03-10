//add content when page loads
document.addEventListener('DOMContentLoaded', bindButtons);
// bind the button

function bindButtons(){
	//gather parameters into json object
	document.getElementById("loginButton").addEventListener('click',function(event){
		var req = new XMLHttpRequest();
		var stateReq = new XMLHttpRequest();
		var fedReq = new XMLHttpRequest();
		var payload = {username:null, password:null, InputType:null}
		payload.username= document.getElementById("username").value;
		payload.password= document.getElementById("password").value;
		payload.InputType= "Login";
		
	
		//validation user has filled in fields
		var fillStatus =0; 
		
		if(payload.username == ""){
			alert("Please Fill out Username");
			fillStatus=1;
		}
		
		else if(payload.password == ""){
			alert("Please Fill out Password");
			fillStatus=1;
		}
		
		//send request if status is 0
		if(fillStatus ==0){
			
			req.open('POST', 'processRequest.php', false);
			req.setRequestHeader('Content-Type', 'application/json');
			req.send(JSON.stringify(payload));
			var response = req.responseText; 
			if(response == 0){
				alert("Your password or username was incorrect.");
			}
			else{
				console.log(response);
				var getid = response;
				sessionStorage.setItem('id', getid);
				console.log(getid);
				console.log(window.location.href);
				window.location = './home.php';

			}
		}
		else{
			alert ("You Suck");
		}
	event.preventDefault();	
	});
}

	
	
