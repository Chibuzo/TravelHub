<?php
require_once "model.class.php";

class BookingModel extends Model {
	private static $db_tbl = 'booking_details';

	function __construct()
	{
		parent::__construct();
	}


	public function getTicketRefNo($ticket_id)
	{
		$sql = "SELECT ticket_no FROM booking_details WHERE id = :ticket_id";
		self::$db->query($sql, array('ticket_id' => $ticket_id));
		return self::$db->fetch('obj');
	}


	public function checkSeatAvailability($boarding_vehicle_id, $seat_no)
	{
		// get the booked seats
		$sql = "SELECT booked_seats, num_of_seats FROM boarding_vehicle bv
				JOIN trips t ON bv.trip_id = t.id
				JOIN vehicle_types vt ON t.vehicle_type_id = vt.id
				WHERE bv.id = :id";

		self::$db->query($sql, array('id' => $boarding_vehicle_id));
		if ($seat_details = self::$db->fetch('obj')) {
			$booked_seats = explode(",", $seat_details->booked_seats);

			/*** Make sure that the selected seat ($seat_no) has not already been booked ***/
			if (in_array($seat_no, $booked_seats)) {
				throw new Exception("Seat $seat_no is no longer available.", "02");
			} else {
				return $seat_details;
			}
		} else {
			throw new Exception ("Invalid booking details", "03");
		}
	}


	function reserveSeat($boarding_vehicle_id, $seat_no)
	{
		try {
			$seat_details = $this->checkSeatAvailability($boarding_vehicle_id, $seat_no);
		} catch (Exception $e) {
			throw new Exception ($e->getMessage(), "02");
		}
		if (!empty($seat_details->booked_seats)) {
			$booked_seats = explode(",", $seat_details->booked_seats);

			// remove seat number duplicates if any
			$booked_seats = array_unique($booked_seats);

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


	function book($boarding_vehicle_id, $seat_no, $channel, $customer_id)
	{
		$ticket_no = $this->generateRefNo();

		$sql = "INSERT INTO " . self::$db_tbl . "
		(ticket_no, channel, boarding_vehicle_id, seat_no, customer_id)
		VALUES
		('$ticket_no', :channel, :boarding_vehicle_id, :seat_no, '$customer_id')";

		$param = array(
			'channel' => $channel,
			'boarding_vehicle_id' => $boarding_vehicle_id,
			'seat_no' => $seat_no
		);

		if (self::$db->query($sql, $param)) {
			return self::$db->getLastInsertId();
		} else {
			return "03"; // Booking wasn't successful
		}
	}


	public function externalBooking($trip_id, $travel_date, $departure_order, $seat_no, $customer_id, $channel)
	{
		// first, get boarding vehicle ID
		$boarding_vehicle_id = self::getBoardingVehicleId($trip_id, $departure_order, $travel_date);
		if ($boarding_vehicle_id == false) { // if vehicle isn't boarding yet, add one
			$trip = new Trip();
			$_trip = $trip->getTrip($trip_id);

			$vehicle = new VehicleModel();
			$vehicle->fixBoardingVehicles($_trip->vehicle_type_id, $_trip->park_map_id, $travel_date, $_trip->travel_id);
			$boarding_vehicle_id = self::getBoardingVehicleId($trip_id, $departure_order, $travel_date);
		}

		// reserve seat, haha
		$result = $this->reserveSeat($boarding_vehicle_id, $seat_no);
		if ($result != $seat_no) {
			throw new Exception ("Couldn't reserve seat. Please try again", "01");
		}

		// complete booking
		$result = $this->book($boarding_vehicle_id, $seat_no, $channel, $customer_id);
		if ($result != true) {
			throw new Exception ("Booking not successful", "02");
		}
		return true;
	}


	public function getBookingDetails($trip_id)
	{
		$sql = "SELECT trips.id trip_id, departure, departure_time, vt.name vehicle_type, num_of_seats, fare, route, company_name, park FROM trips
					JOIN vehicle_types vt ON trips.vehicle_type_id = vt.id
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
                INNER JOIN vehicle_types ON vehicle_types.id = trips.vehicle_type_id
                ORDER BY date_booked DESC {$limit}";

		self::$db->query($sql);
		return self::$db->fetchAll('obj');
	}

    public function getByTravel($travel_id, $limit = null)
    {
        if ($limit != null) {
            $limit = "LIMIT 0, $limit";
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
                INNER JOIN vehicle_types ON vehicle_types.id = trips.vehicle_type_id
                WHERE trips.travel_id = :travel_id
                ORDER BY date_booked DESC
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
                INNER JOIN vehicle_types ON vehicle_types.id = trips.vehicle_type_id
                INNER JOIN states ON states.id = op.state_id
                WHERE trips.travel_id = :travel_id AND states.id = :state_id
                {$limit}";

        self::$db->query($sql, array('travel_id' => $travel_id, 'state_id' => $state_id));
        return self::$db->fetchAll('obj');
    }

    public function getByTravelPark($travel_id, $park_id, $limit = null)
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
                INNER JOIN vehicle_types ON vehicle_types.id = trips.vehicle_type_id
                INNER JOIN states ON states.id = op.state_id
                WHERE trips.travel_id = :travel_id AND op.id = :park_id
                {$limit}";

        self::$db->query($sql, array('travel_id' => $travel_id, 'park_id' => $park_id));
        return self::$db->fetchAll('obj');
    }


	public function getBoardingVehicleId($trip_id, $departure_order, $travel_date)
	{
		if (empty($departure_order)) {	// query currently boarding vehicle5
			$query = "AND seat_status = 'Not full'";
			$param = array(
				'trip_id' => $trip_id,
				'travel_date' => $travel_date
			);
		} else {
			$query = "AND departure_order = :departure_order";
			$param = array(
				'trip_id' => $trip_id,
				'departure_order' => $departure_order,
				'travel_date' => $travel_date
			);
		}
		$sql = "SELECT id, departure_order, booked_seats FROM boarding_vehicle WHERE trip_id = :trip_id AND travel_date = :travel_date $query";

		self::$db->query($sql, $param);
		if ($d = self::$db->fetch('obj')) {
			return $d->id;
		} else {
			return false;
		}
	}


	public function cancelTicketFromDepot($trip_id, $departure_order, $travel_date, $seat_no)
	{
		$sql = "SELECT bv.booked_seats, bv.id bb_id, seat_no, bd.id ticket_id FROM " . self::$db_tbl . " bd
				JOIN boarding_vehicle bv ON bd.boarding_vehicle_id = bv.id
				WHERE trip_id = :trip_id AND departure_order = :departure_order AND bv.travel_date = :travel_date AND bd.seat_no = :seat_no";

		$param = array(
			'trip_id' => $trip_id,
			'departure_order' => $departure_order,
			'travel_date' => $travel_date,
			'seat_no' => $seat_no
		);
		self::$db->query($sql, $param);
		if ($details = self::$db->fetch('obj')) {
			$seats = explode(",", $details->booked_seats);
			foreach ($seats AS $key => $value) if ($seats[$key] == $details->seat_no) unset($seats[$key]);
			$remaining_seats = implode(',', $seats);

			// lets do some transactions
			$query_check = true;
			self::$db->beginDbTransaction();
			$sql = "UPDATE boarding_vehicle SET booked_seats = '$remaining_seats', seat_status = 'Not full'
					WHERE id = '$details->bb_id'";

			self::$db->query($sql) ? null : $query_check = false;

			self::$db->query("DELETE FROM booking_details WHERE id = :id", array('id' => $details->ticket_id)) ? null : $query_check = false;

			if ($query_check == true) {
				self::$db->commitTransaction();
				return true;
			} else {
				self::$db->rollBackTransaction();
				return false;
			}
		} else {
			echo "Not Found";
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
