<?php
session_start();
require_once "../api/models/bookingmodel.class.php";
require_once "../api/models/customer.class.php";
require_once "../api/models/travel.class.php";
require_once "../api/models/bookingissues.class.php";

extract($_POST);

// record booking details
$booking = new BookingModel();

if ($_REQUEST['op'] == 'complete-booking')
{
	try {
		// handle customer
		$customer = new Customer();
		$_customer = $customer->getCustomer('phone_no', $_POST['customer_phone']);
		$customer_id = $_customer['id'];
		if (isset($_customer['id']) === false) {
			$customer->customer_name = $_POST['customer_name'];
			$customer->phone_no = $_POST['customer_phone'];
			$customer->next_of_kin_phone = $_POST['next_of_kin_phone'];
			$customer_id = $customer->addNew($customer);
		}
		$_SESSION['seat_no'] = $booking->reserveSeat($boarding_vehicle_id, $seat_no);
		$_SESSION['ticket_id'] = $booking->book($_POST['boarding_vehicle_id'], $seat_no, $channel, $customer_id);
		require_once "../includes/sms.php";
		echo sendMTicket($_SESSION['ticket_id']);
		die();
		// send booking details to terminal
		$travel = new Travel();
		$_travel = $travel->getTravelDepot($_SESSION['trip_id']);
		$terminal = $_travel->abbr . '_' . implode("-", explode(" ", $_travel->park));

		$details = array(
				'category'          => $terminal,
				'trip_id'           => $_SESSION['trip_id'],
				'travel_date'       => $_SESSION['travel_date'],
				'seat_no'           => $seat_no,
				'departure_order'   => $_SESSION['departure_order'],
				'customer_name'     => $_POST['customer_name'],
				'customer_phone'    => $_POST['customer_phone'],
				'next_of_kin_phone' => $_POST['next_of_kin_phone'],
				'channel'           => 'online'
		);

		$status = BookingModel::pushData($details, 'booking');
		if ($status == 'Disconnected') {
			$bookIssue = new BookingIssues();
			$bookIssue->logFailedPush($_SESSION['trip_id'], $_SESSION['travel_date'], $seat_no, $_SESSION['departure_order'], $_POST['customer_phone'], $_POST['customer_phone'], $_POST['next_of_kin_phone'], $channel, $terminal, $status);
		}
	} catch (Exception $e) {
		echo $e->getCode();
	}
}
elseif ($_REQUEST['op'] == 'check-seat-availability')
{
	try {
		$booking->checkSeatAvailability($boarding_vehicle_id, $seat_no);
	} catch (Exception $e) {
		echo $e->getCode();
	}
}

