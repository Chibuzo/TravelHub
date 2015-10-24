<?php

session_start();

if ($_REQUEST['op'] == 'ticket_details')
{
	$_SESSION['seat_no']             = $_REQUEST['seat_no'];
	$_SESSION['bus_id']      = $_REQUEST['bus_id'];
	$_SESSION['travel_date'] = $_REQUEST['travel_date'];
	//$_SESSION['departure_time']      = $_REQUEST['departure_time'];
}
elseif ($_REQUEST['op'] == 'checkout_details')
{
	$_SESSION['payment_opt'] = $_REQUEST['payment_opt'];
	$_SESSION['ticket_id']   = $_REQUEST['ticket_id'];
	$_SESSION['status']      = 'SUCCESS';

	if ($_REQUEST['payment_opt'] == 'pay_later') {
		require_once "sms.php";
		sendMTicket($_REQUEST['ticket_id']);
	}
}

?>
