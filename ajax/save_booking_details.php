<?php
session_start();
require_once "../api/models/seatmodel.class.php";
require_once "../api/models/bookingmodel.class.php";
require_once "../api/models/customer.class.php";

if (isset($_POST['customer_name'], $_POST['next_of_kin_phone'], $_POST['customer_phone'])) {
	extract($_POST);

	// handle customer
	//$customer = new Customer();
	//$customer_id = $customer->findCustomer('phone_no', $customer_phone);
	//if (is_numeric($customer_id) === false) {
	//	$param = array(
	//		'c_name' => $customer_name,
	//		'phone_no' => $customer_phone,
	//		'next_of_kin_phone' => $next_of_kin_phone
	//	);
	//	$customer_id = $customer->addNew($param);
	//}
} else {
	echo '{"msg" : "04"}';
	exit;
}

// reserve seat
$seat = new SeatModel();
if (is_numeric($_POST['boarding_bus_id']))	// using seat picker
	$_SESSION['seat_no'] = $seat->reserveSeat($boarding_bus_id, $seat_no);
else // booking without seat number
	$_SESSION['seat_no'] = $seat->assignSeatNumber($_SESSION['fare_id'], $_SESSION['travel_date'], $_SESSION['num_of_seats']);

// record booking details
$booking = new BookingModel();

// check for discount eligibilty
//if ($booking->countUserTickets() == 2) {
//	echo "10"; // give discount
//	exit;
//}
echo $booking->book($_SESSION['boarding_bus_id'], $_SESSION['seat_no'], $payment_opt, $_SESSION['fare'], $customer_name, $next_of_kin_phone, $customer_phone);
?>
