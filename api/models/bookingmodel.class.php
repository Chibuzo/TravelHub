<?php
require_once "model.class.php";

class BookingModel extends Model {
	private static $db_tbl = 'booking_details';

	function __construct()
	{
		parent::__construct();
	}


	function reserveSeat($boarding_vehicle_id, $seat_no) {
		// get the booked seats
		$sql = "SELECT booked_seats, num_of_seats FROM boarding_vehicle bv
				JOIN fares f ON bv.fare_id = f.id
				JOIN vehicle_types vt ON f.vehicle_type_id = vt.id
				WHERE bv.id = :id";

		self::$db->query($sql, array('id' => $boarding_vehicle_id));
		$seat_details = self::$db->fetch('obj');

		if (!empty($seat_details->booked_seats)) {
			$booked_seats = explode(",", $seat_details->booked_seats);

			/*** Make sure no seat number repeats itself, and that the selected seat ($seat_no) has not already been booked ***/
			$booked_seats = array_unique($booked_seats);
			if (in_array($seat_no, $booked_seats)) {
				return "02"; // Error code 02 - Seat number no longer available;
			}

			# If there is any empty seat/array, remove it
			foreach ($booked_seats AS $key => $value) if (empty($value)) unset($booked_seats[$key]);
			$booked_seats = array_values($booked_seats);
			$num_of_seats_booked = count($booked_seats);

			$booked_seats = implode(",", $booked_seats);
			$booked_seats .= ',' . $seat_no;
		} else {
			$booked_seats = $seat_no;
			$num_of_seats_booked = 1;
		}

		# START TRANSACTION
		self::$db->beginDbTransaction();
		$query_check = true;

		// Check if the seats are filled
		$status = 'Not full';
		if ($num_of_seats_booked + 1 == $seat_details->num_of_seats)
			$status = 'Full';

		$sql = "UPDATE boarding_vehicle SET
					booked_seats = '$booked_seats',
					seat_status = '$status'
				WHERE id = :boarding_vehicle_id";

		self::$db->query($sql, array('boarding_vehicle_id' => $boarding_vehicle_id)) ? null : $query_check = false;

		if ($query_check == false) {
			self::$db->rollBackTransaction();
			return false;
		} else
			self::$db->commitTransaction();
		return $seat_no;
	}


	function book($boarding_vehicle_id, $seat_no, $payment_opt, $customer_id)
	{
		$ticket_no = $this->generateRefNo();

		$sql = "INSERT INTO " . self::$db_tbl . "
		(ticket_no, payment_opt, boarding_vehicle_id, seat_no, customer_id)
		VALUES
		('$ticket_no', :payment_opt, :boarding_vehicle_id, :seat_no, '$customer_id')";

		$param = array(
			'payment_opt' => $payment_opt,
			'boarding_vehicle_id' => $boarding_vehicle_id,
			'seat_no' => $seat_no
		);

		if (self::$db->query($sql, $param)) {
			$bd_id = self::$db->getLastInsertId();

			$_SESSION['ticket_id'] = $bd_id;

			return '{"msg" : "' . $bd_id . '"}';
		} else {
			return '{"msg" : "03"}'; // Booking wasn't successful
		}
	}


	public function getBookingDetails($fare_id)
	{
		$sql = "SELECT f.id fare_id, vt.name vehicle_type, num_of_seats, fare, route, company_name, park FROM fares f
					JOIN vehicle_types vt ON f.vehicle_type_id = vt.id
					JOIN routes r ON r.id = f.route_id
					JOIN travels t ON f.travel_id = t.id
					JOIN park_map pm ON f.park_map_id = pm.id
					JOIN parks p ON pm.destination = p.id
				WHERE f.id = '$fare_id'";

		self::$db->query($sql);
		return self::$db->fetch('obj');
	}


	public function getBookings($limit = null)
	{
		if ($limit != null) {
			$limit = "LIMIT 0, 5";
		}
		$sql = "SELECT bd.*, name bus_type, route FROM " . self::$db_tbl . " bd
				JOIN routes r ON bd.route_id = r.id
				JOIN boarding_vehicle bb ON bd.boarding_bus_id = bb.id
				JOIN fares f ON bb.fare_id = f.id
				JOIN vehicle_types bt ON f.vehicle_type_id = bt.id
				WHERE bd.status = '1'
				ORDER BY travel_date DESC
				{$limit}";

		self::$db->query($sql);
		return self::$db->fetchAll('obj');
	}


	function cancelBooking($id = null, $travel_date = null, $ref_no = null)
	{
		if ($id != null) {
			$sql = "UPDATE " . self::$db_tbl . " SET status = '0' WHERE id = :id";
		}
		if (self::$db->query($sql, array('id' => $id))) {
			return true;
		}
	}


	function generateRefNo()
	{
		$find    = array('/', '+', '=', "\\", '|', '-');
		$replace = array('X', 'Y', 'Z', 'U', 'O', '4');
		return strtoupper(str_replace($find, $replace, base64_encode(mcrypt_create_iv(6, MCRYPT_RAND))));
	}


	function countUserTickets($customer_id) {
		$sql = "SELECT COUNT(*) AS num_row FROM " . self::$db_tbl . " WHERE customer_id = :customer_id AND payment_status = 'Paid'";
        self::$db->query($sql, array('customer_id' => $customer_id));
		$count = self::$db->fetch('obj');
		return $count->num_rows;
	}
}
?>
