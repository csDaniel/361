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
		* @dataProvider loginProvider
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
			$this->assertTrue($data > 0);	
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
