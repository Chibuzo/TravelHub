<?php
session_start();
//require_once "../api/models/seatmodel.class.php";
require_once "../api/models/bookingmodel.class.php";
require_once "../api/models/customer.class.php";

extract($_POST);
if (isset($_POST['customer_name'], $_POST['next_of_kin_phone'], $_POST['customer_phone'])) {

	// handle customer
	$customer = new Customer();
	$_customer = $customer->getCustomer('phone_no', $customer_phone);
	if (isset($_customer['id']) === false) {
		$customer->customer_name = $_POST['customer_name'];
		$customer->phone_no = $_POST['customer_phone'];
		$customer->next_of_kin_phone = $_POST['next_of_kin_phone'];
		$customer_id = $customer->addNew($customer);
	}
}

// record booking details
$booking = new BookingModel();

if ($_REQUEST['op'] == 'reserve-seat')
{
	try {
		$_SESSION['seat_no'] = $booking->reserveSeat($boarding_vehicle_id, $seat_no);
	} catch (Exception $e) {
		echo $e->getCode();
	}
} else {
	$booking->book($_SESSION['boarding_vehicle_id'], $seat_no, $channel, $customer_id);
}

