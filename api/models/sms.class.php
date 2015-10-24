<?php

class Sms {

	function __construct()
	{
		
	}
	
	
	function sendBookingAlert() {
		$param["user"] = "chibuzo"; 				//this is the username of our TM4B account
		$param["cypher"] = "oya.com.ng"; 				//this is the password of our TM4B account
		$param["recipient"] = "08142690852";
		$param["sender"] = "oya.com.ng";
		$param["message"] = "There's an online bus ticket reservation at oya.com.ng";
		$param['resp_type'] = "html";
		
		$request = '';
		foreach($param as $key=>$val) 				//traverse through each member of the param array
		{ 
		  $request.= $key."=".rawurlencode($val); 		//we have to urlencode the values
		  $request.= "&"; 					//append the ampersand (&) sign after each paramter/value pair
		}
		$request = substr($request, 0, strlen($request)-1); 	//remove the final ampersand sign from the request
		
		//First prepare the info that relates to the connection
		$host = "api.smstorrent.net"; 				//The API domain 
		$script = "/http/";					//the script location
		$request_length = strlen($request);
		$method = "POST"; 					// must be POST if sending large no of  messages
		if ($method == "GET"){
		  $script .= "?$request";
		}
		
		//Now comes the header which we are going to post. 
		$header = "$method $script HTTP/1.1\r\n";
		$header .= "Host: $host\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: $request_length\r\n";
		$header .= "Connection: close\r\n\r\n";
		$header .= "$request\r\n";
		
		//Now we open up the connection
		$socket = @fsockopen($host, 80, $errno, $errstr); 
		if ($socket) //if its open, then...
		{ 
		  fputs($socket, $header); 			// send the details over
		  while(!feof($socket))
		  {
			fgets($socket); 		//get the results 
		  }
		  fclose($socket); 
		} else {
			//echo "SMS sending failed:: Reason: could not connect to gateway!";
		}
	}
}

?>