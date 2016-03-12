<?php
session_start();
//require_once "../api/models/seatmodel.class.php";
require_once "../api/models/bookingmodel.class.php";
require_once "../api/models/customer.class.php";

extract($_POST);
if (isset($_POST['customer_name'], $_POST['next_of_kin_phone'], $_POST['customer_phone'])) {

	// handle customer
	$customer = new Customer();
	$customer_id = $customer->findCustomer('phone_no', $customer_phone);
	if (is_numeric($customer_id) === false) {
		$param = array(
			'c_name' => $customer_name,
			'phone_no' => $customer_phone,
			'next_of_kin_phone' => $next_of_kin_phone
		);
		$customer_id = $customer->addNew($param);
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
	$booking->book($_SESSION['boarding_vehicle_id'], $seat_no, $payment_opt, $customer_id);
}

