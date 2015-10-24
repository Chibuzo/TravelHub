<?php
require_once "model.class.php";

class SeatModel extends Model {

	function __construct()
	{
		parent::__construct();
	}


	function reserveSeat($boarding_bus_id, $seat_no) {
		// get the booked seats
		$sql = "SELECT booked_seats, num_of_seats FROM boarding_bus bb
				JOIN fares f ON bb.fare_id = f.id
				JOIN bus_types bt ON f.bus_type_id = bt.id
				WHERE bb.id = :id";

		$this->db->query($sql, array('id' => $boarding_bus_id));
		$seat_details = $this->db->fetch('obj');

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
		$this->db->beginDbTransaction();
		$query_check = true;

		// Check if the seats are filled
		$status = 'Not full';
		if ($num_of_seats_booked + 1 == $seat_details->num_of_seats)
			$status = 'Full';

		$sql = "UPDATE boarding_bus SET
					booked_seats = '$booked_seats',
					seat_status = '$status'
				WHERE id = :boarding_bus_id";

		$this->db->query($sql, array('boarding_bus_id' => $boarding_bus_id)) ? null : $query_check = false;

		if ($query_check == false) {
			$this->db->rollBackTransaction();
			return false;
		} else
			$this->db->commitTransaction();
		return $seat_no;
	}


	function assignSeatNumber($bus_id, $travel_date, $num_of_seats)
	{
		$sql = "SELECT booked_seats, seats, tb.id FROM boarding_bus AS tb
				JOIN buses AS b ON tb.bus_id = b.id
				WHERE seat_status = 'Not full' AND bus_id = '$bus_id' AND travel_date = '$travel_date'";

		$this->db->query($sql);
		$details = $this->db->fetch('obj');
		if (isset($details->id))
		{
			$booked_seats = explode(',', $details->booked_seats);

			# Get free seats
			for ($i = 1; $i < $details->seats + 1; $i++) {
				if (in_array($i, $booked_seats)) continue;
				$free_seats[] = $i;
			}

			$seat_index = array_rand($free_seats, 1);
			$seat_no = $free_seats[$seat_index];

			# Book for seat
			$this->db->query("UPDATE boarding_bus SET booked_seats = CONCAT(booked_seats, ',', '$seat_no') WHERE id = '$details->id'");
			$_SESSION['boarding_bus_id'] = $details->id;
		} else {

			$sql = "INSERT INTO ticket_booking
					(bus_id, booked_seats, num_of_seats, departure_order, service_charge, travel_date)
					VALUES
					(:bus_id, '1', :num_of_seats, '1', '{$service_charge->online_charge}', :travel_date)";

			$param = array('bus_id' => $bus_id, 'num_of_seats' => $num_of_seats, 'travel_date' => $travel_date);

			$this->db->query($sql, $param);
			$_SESSION['boarding_bus_id'] = $this->db->getLastInsertId();
			return '{"msg" : "0"}';
		}
	}
}

?>
