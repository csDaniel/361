#!/usr/bin/php
<?php

	// source: https://ole.michelsen.dk/blog/testing-your-api-with-phpunit.html
	// Requires guzzle (I installed in home directory)
	$home = getenv("HOME");
	require ($home.'/vendor/autoload.php');


	// src: https://knpuniversity.com/screencast.rest/testing-phpunit
	class LoginTest extends PHPUnit_Framework_TestCase
	{	
    // accountTest, loginProvider, addPol, findPol
		/**
		* @dataProvider findPol
		*/
		public function testLogin($input)
		{
			$this->client = new GuzzleHttp\Client([
				'base_uri' => 'http://web.engr.oregonstate.edu/~hueymi/361/']);	
		
			// Sending the post request
			$response = $this->client->post('ProcessRequest.php', [
				'json' => $input]);


			$this->assertEquals(200, $response->getStatusCode());
			$data = json_decode($response->getBody(), true);
			
			// In theory, this should return the id of the user
      echo $data;
			$this->assertTrue($data > 0) ;
		}
		
    // will run a series of tests in creating accounts to test for outliers 
    public function accountTest() {
      $name = 'damnDaniels';
      $address = '600 Lincoln Ave';
      $city = 'Charleston';
      $state = 'IL';
      $lat = '39.4844';
      $lon = '88.1753';
      $zipcode = '61920';
      
      $bigname = $name;
      for ($i = 0; $i <= 50; $i++) {
        $bigname = $bigname . $name;
      }

        return array( 
          'registering new user' => array(
            [
              'InputType'=>'CreateAccount',
              'username'=> $name,
              'password'=> $name,
              'firstname'=> $name,
              'lastname'=> $name,
              'address'=> $address,
              'city'=> $city,
              'zipcode'=> $zipcode,
              'state'=> $state,
              'latitude'=> $lat,
              'longitude'=> $lon           
            ]
          ),          
          'registering same user' => array(
            [
              'InputType'=>'CreateAccount',
              'username'=> $name,
              'password'=> $name,
              'firstname'=> $name,
              'lastname'=> $name,
              'address'=> $address,
              'city'=> $city,
              'zipcode'=> $zipcode,
              'state'=> $state,
              'latitude'=> $lat,
              'longitude'=> $lon           
            ]
          ),          
          'missing fields new user' => array(
            [
              'InputType'=>'CreateAccount',
              'username'=> $name,
              'password'=> $name,
              'firstname'=> $name,
              'lastname'=> "",
              'address'=> $address,
              'city'=> $city,
              'zipcode'=> $zipcode,
              'state'=> $state,
              'latitude'=> $lat,
              'longitude'=> $lon           
            ]
          ),          
           'Giant name new user' => array(
            [
              'InputType'=>'CreateAccount',
              'username'=> $bigname,
              'password'=> $name,
              'firstname'=> $name,
              'lastname'=> $name,
              'address'=> $address,
              'city'=> $city,
              'zipcode'=> $zipcode,
              'state'=> $state,
              'latitude'=> $lat,
              'longitude'=> $lon           
            ]
          ),        
          'badChar new user' => array(
            [
              'InputType'=>'CreateAccount',
              'username'=> $name.'?#',
              'password'=> $name,
              'firstname'=> $name,
              'lastname'=> $name,
              'address'=> $address,
              'city'=> $city,
              'zipcode'=> $zipcode,
              'state'=> $state,
              'latitude'=> $lat,
              'longitude'=> $lon           
            ]
          )          
        );   
    }
      
		// It'll plug in these values to the other function
		// as long as you call this one its "dataProvider" above that function 
		public function loginProvider()
		{
			// The weird thing is you have to return an array of arrays
			return array(
				'logging in Bob' => array(
					[
						'InputType'=>'Login',
						'username' => 'Bob',
						'password' => 'bob'
					]
				),
				'logging in Jane' => array(
					[
						'InputType'=>'Login',
						'username'=> 'Jane',
						'password'=>'jane'
					]			
				),
        'logging in with missing fields' => array(
					[
						'InputType'=>'Login',
						'username'=> "",
						'password'=>'jane'
					]			
				),
        'logging in Jane bad password' => array(
					[
						'InputType'=>'Login',
						'username'=> 'Jane',
						'password'=>'badpassword'
					]			
				),
				'username not in db' => array(
					[
						'InputType' => 'What',
						'username' => 'where',
						'password' => 'why'
					]
				)
			);			
		}
    
    public function addPol() {
      $userid = 4;
      $repid = 'ILL000049';
      $local = 1;
    
			return array(
				'normal case' => array(
					[
            'InputType'=>'AddPolitician',
						'userid'=>$userid,
						'repid' =>$repid
					]
				),
				'userid is not in table' => array(
					[
            'InputType'=>'AddPolitician',
						'userid'=>9000,
						'repid' =>$repid
					]
				),
				'userid is bad' => array(
					[
            'InputType'=>'AddPolitician',
						'userid'=>'bananas',
						'repid' =>$repid
					]
				),        
				'repid is bad' => array(
					[
            'InputType'=>'AddPolitician',
						'userid'=>$userid,
						'repid' =>9000
					]
				),
				'adding the same rep' => array(
					[
            'InputType'=>'AddPolitician',
						'userid'=>$userid,
						'repid' =>$repid
					]
				),
				'missing userid' => array(
					[
            'InputType'=>'AddPolitician',          
						'userid'=>"",
						'repid' =>$repid
					]
				)                
      );
    }	
    
    public function findPol()
		{
      $userid = 7;
			return array(
				'normal findPol search' => array(
					[
						'InputType'=>'FindPolitician',
						'userid' => $userid
					]
				),
				'no userid search' => array(
					[
						'InputType'=>'FindPolitician',
						'userid' => ""
					]
				),      
				'bad userid search' => array(
					[
						'InputType'=>'FindPolitician',
						'userid' => "$4"
					]
				)
      );
    }
	}	
		
?>
