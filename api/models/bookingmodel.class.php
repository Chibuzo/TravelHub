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
				JOIN trips t ON bv.trip_id = t.id
				JOIN vehicle_types vt ON t.vehicle_type = vt.id
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


	public function getBookingDetails($trip_id)
	{
		$sql = "SELECT trips.id trip_id, vt.name vehicle_type, num_of_seats, fare, route, company_name, park FROM trips
					JOIN vehicle_types vt ON trips.vehicle_type = vt.id
					JOIN routes r ON r.id = trips.route_id
					JOIN travels t ON trips.travel_id = t.id
					JOIN park_map pm ON trips.park_map_id = pm.id
					JOIN parks p ON pm.destination = p.id
				WHERE trips.id = '$trip_id'";

		self::$db->query($sql);
		return self::$db->fetch('obj');
	}


	public function getBookings($limit = null)
	{
		if ($limit != null) {
			$limit = "LIMIT 0, 5";
		}
        $sql = "SELECT booking_details.*, boarding_vehicle.travel_date AS travel_date, customers.c_name, customers.phone_no, trips.fare, travels.company_name, CONCAT(op.park, ' - ', dp.park) AS route, vehicle_types.`name` AS vehicle_type
                FROM " . self::$db_tbl . "
                INNER JOIN boarding_vehicle ON boarding_vehicle.id = booking_details.boarding_vehicle_id
                INNER JOIN trips ON trips.id = boarding_vehicle.trip_id
                INNER JOIN travels ON travels.id = trips.travel_id
                INNER JOIN customers ON customers.id = booking_details.customer_id
                INNER JOIN park_map pm ON pm.id = trips.park_map_id
                INNER JOIN parks op ON pm.origin = op.id
                INNER JOIN parks dp ON pm.destination = dp.id
                INNER JOIN vehicle_types ON vehicle_types.id = trips.vehicle_type
                {$limit}";

		self::$db->query($sql);
		return self::$db->fetchAll('obj');
	}

    public function getByTravel($travel_id, $limit = null)
    {
        if ($limit != null) {
            $limit = "LIMIT 0, 5";
        }
        $sql = "SELECT booking_details.*, boarding_vehicle.travel_date AS travel_date, customers.c_name, customers.phone_no, trips.fare, travels.company_name, CONCAT(op.park, ' - ', dp.park) AS route, vehicle_types.`name` AS vehicle_type
                FROM " . self::$db_tbl . "
                INNER JOIN boarding_vehicle ON boarding_vehicle.id = booking_details.boarding_vehicle_id
                INNER JOIN trips ON trips.id = boarding_vehicle.trip_id
                INNER JOIN travels ON travels.id = trips.travel_id
                INNER JOIN customers ON customers.id = booking_details.customer_id
                INNER JOIN park_map pm ON pm.id = trips.park_map_id
                INNER JOIN parks op ON pm.origin = op.id
                INNER JOIN parks dp ON pm.destination = dp.id
                INNER JOIN vehicle_types ON vehicle_types.id = trips.vehicle_type
                WHERE trips.travel_id = :travel_id
                {$limit}";

        self::$db->query($sql, array('travel_id' => $travel_id));
        return self::$db->fetchAll('obj');
    }

    public function getByTravelState($travel_id, $state_id, $limit = null)
    {
        if ($limit != null) {
            $limit = "LIMIT 0, 5";
        }
        $sql = "SELECT booking_details.*, boarding_vehicle.travel_date AS travel_date, customers.c_name, customers.phone_no, trips.fare, travels.company_name, CONCAT(op.park, ' - ', dp.park) AS route, vehicle_types.`name` AS vehicle_type
                FROM " . self::$db_tbl . "
                INNER JOIN boarding_vehicle ON boarding_vehicle.id = booking_details.boarding_vehicle_id
                INNER JOIN trips ON trips.id = boarding_vehicle.trip_id
                INNER JOIN travels ON travels.id = trips.travel_id
                INNER JOIN customers ON customers.id = booking_details.customer_id
                INNER JOIN park_map pm ON pm.id = trips.park_map_id
                INNER JOIN parks op ON pm.origin = op.id
                INNER JOIN parks dp ON pm.destination = dp.id
                INNER JOIN vehicle_types ON vehicle_types.id = trips.vehicle_type
                INNER JOIN states ON states.id = op.state_id
                WHERE trips.travel_id = :travel_id AND states.id = :state_id
                {$limit}";

        self::$db->query($sql, array('travel_id' => $travel_id, 'state_id' => $state_id));
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
