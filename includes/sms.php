<?php

function sendMTicket($ticket_id) {
	require_once "db_handle.php";

	$sql = "SELECT ticket_no, c_name, next_of_kin_phone, phone_no, fare, terminal, date_booked, travel_date, route FROM booking_details bd
			JOIN routes r ON r.id = bd.route_id
			WHERE bd.id = :ticket_id";

	$db->query($sql, array('ticket_id' => $ticket_id));

	extract($db->fetch());
	$param["user"] = "chibuzo"; 				//this is the username of our TM4B account
	$param["cypher"] = "oya.com.ng"; 				//this is the password of our TM4B account
	$param["recipient"] = $phone_no;
	$param["sender"] = "Autostar";
	$param["resp_type"]= "html";
	$param["message"] = "-- Autostar mTicket --

	<Ref no> $ticket_no
	<Route> $route
	<Company> Autostar Tavels
	<Name> $c_name
	<Fare> $fare NGN
	<Park> {$terminal}
	<Travel date> " . date('D, d M Y', strtotime($travel_date)) . "
	<Date booked> " . date('D, d M Y', strtotime($date_booked)) . "
	\nHelpline: (070) 0400 0000";

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
		echo trim(fgets($socket)); 		//get the results
	  }
	  fclose($socket);
	} else {
		echo "SMS sending failed:: Reason: could not connect to gateway!";
	}
}
?>
