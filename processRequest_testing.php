#!/usr/bin/php
<?php

	// source: https://ole.michelsen.dk/blog/testing-your-api-with-phpunit.html
	// Requires guzzle (I installed in home directory)
	$home = getenv("HOME");
	require ($home.'/vendor/autoload.php');


	// src: https://knpuniversity.com/screencast.rest/testing-phpunit
	class LoginTest extends PHPUnit_Framework_TestCase
	{	
		/**
		* @dataProvider makeAccountTest
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
      
			$this->assertTrue($data > 0) ;
		}
		
    // will run a series of tests in creating accounts to test for outliers 
    public function makeAccountTest() {
      $name = 'Daniel';
      $address = '600 Lincoln Ave';
      $city = 'Charleston';
      $state = 'IL';
      $lat = '39.4844';
      $lon = '88.1753';
      $zipcode = '61920';
      
      for ($x = 0; $x <= 100; $x++) {
        echo $x;
        $nameTesting = $name + (string)$x;
        return array( 
          'registering new user' => array(
            [
              'InputType'=>'CreateAccount',
              'username'=> $nameTesting,
              'password'=> $nameTesting,
              'firstname'=> $nameTesting,
              'lastname'=> $nameTesting,
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
				)
/*				'should not work' => array(
					[
						'InputType' => 'What',
						'username' => 'where',
						'password' => 'why'
					]
				) */
			);
			
		}
	}	

		
?>
