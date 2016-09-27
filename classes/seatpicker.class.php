<?php
require_once "../api/models/model.class.php";
require_once "../api/models/vehiclemodel.class.php";

class SeatPicker extends Model {
	public $vehicle_type_id;
	public $fare;
	public $trip_id;
	public $travel_date;
	public $park_map_id;
	public $travel_id;
	public $num_of_seats;
	public $boarding_vehicle_type_id = null;
	public $booked_seats;
	public $seat_status;
	public $departure_order = 0;
	public $departure_time = '';

	private $tbl = 'boarding_vehicle';

	function __construct($park_map_id, $travel_date, $num_of_seats, $vehicle_type_id, $fare, $trip_id, $travel_id, $departure_order = 0, $departure_time = null)
	{
		parent::__construct();

		$this->travel_date = $travel_date;
		$this->num_of_seats = $num_of_seats;
		$this->vehicle_type_id = $vehicle_type_id;
		$this->fare = $fare;
		$this->trip_id = $trip_id;
		//$this->route_id = $route_id;
		$this->park_map_id = $park_map_id;
		$this->travel_id = $travel_id;
		$this->departure_order = $departure_order;
		$this->departure_time = $departure_time;
	}


	function getSeatChart()
	{
		$this->getBoardingVehicleDetails();

		switch ($this->vehicle_type_id) {
			case 3:
			case 5:
				return self::getLuxurySeats();
				break;
			case 8: // toyota hiace
				return self::getToyotaHiaceSeatsA();
				break;
			case 10:
			case 13:
				return self::getNissianUrvanSeats();
				break;
			case 15:
				return self::getToyotaHiaceSeatsB();
				break;
			case 19:
				return $this->getCoaterSeats();
				break;
		}
	}


	function findBoardingVehicle()
	{
		$sql = "SELECT id, booked_seats, seat_status FROM {$this->tbl}
				WHERE trip_id = :trip_id
				AND travel_date = :travel_date";

		$param = array(
			'trip_id' => $this->trip_id,
			'travel_date' => $this->travel_date
		);

		self::$db->query($sql, $param);
		if ($vehicle = self::$db->fetch('obj')) {
			return $vehicle;
		} else {
			return false;
		}
	}


	function getBoardingVehicleDetails()
	{
		$data = $this->findBoardingVehicle();
		if ($data != false) {
			$this->boarding_vehicle_id = $data->id;
			$this->booked_seats = explode(',', $data->booked_seats);
			$this->seat_status =  $data->seat_status;
		} else {
			$vehicle = new VehicleModel();
			$vehicle->fixBoardingVehicles($this->vehicle_type_id, $this->park_map_id, $this->travel_date, $this->travel_id);
			$data = $this->findBoardingVehicle();

			$this->booked_seats = array();
			$this->boarding_vehicle_id = $data->id;
			$this->seat_status = 'Not full';
		}
	}


	/**
	 *  Toyota hiace with passage by the window
	 */
	function getToyotaHiaceSeatsB()
	{
		$booked_seats = $this->booked_seats;
		$seat_arrangement = $this->upperSittingDetails('mini-bus');

		$counter = 0;
		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$class = "class='seat'";

			$seat = $i;
			if (in_array($seat, $booked_seats)) $class = "class='booked_seat'";
			if ($counter == 0) $seat_arrangement .= $i <= 1 ? "<div class='front-row'>" : "<div class='seat-row'>";

			$seat_arrangement .= "\t<div {$class} data-hidden='no'  title='Seat {$seat}' id='{$seat}'></div>";
			$counter++;

			if ($this->num_of_seats == 15 && $i == 2) { // For one seat at the front
				$seat_arrangement .= "</div>"; // Close cols for the seat at the front
				$counter = 0;
				$row1 = 5; $row2 = 7; $row3 = 10;
			} else {
				$row1 = 4; $row2 = 6; $row3 = 9;
			}

			if ($i == $row1) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			} elseif ($i == $row2) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			} elseif ($i == $row3) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			}
			//if ($i == 2) continue;

			if ($i == 1 || $counter == 4) {
				$counter = 0;
				$seat_arrangement .= "</div>"; // Close cols
			}
		}
		if ($counter == 1) $seat_arrangement .= "</div>";
		$seat_arrangement .= "\n</div>\n";

		return $seat_arrangement .= $this->lowerSittingDetails();
	}

	/**
	 *  Toyota hiace with passage in between seats
	 */
	/*function getToyotaHiaceSeatsB()
	{
		$booked_seats = $this->booked_seats;
		$seat_arrangement = $this->upperSittingDetails('mini-bus');

		$counter = 0;
		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$class = "class='seat'";

			$seat = $i;
			if (in_array($seat, $booked_seats)) $class = "class='booked_seat'";

			// exchange arrays to match seating arrangement
			if ($seat % 3 == 0) $seat += 2;
			elseif ($seat % 3 == 2) $seat -= 2;

			// front seats
			if ($i == 1) $seat = 2;
			elseif ($i == 2) $seat = 1;
			// back seats
			elseif ($i == 12) $seat = 15;
			elseif ($i == 13) $seat = 14;
			elseif ($i == 14) $seat = 13;
			elseif ($i == 15) $seat = 12;

			if ($counter == 0) $seat_arrangement .= "<div class='cols'>";
			$seat_arrangement .= "\t<div {$class} data-hidden='no' title='Seat {$seat}' id='{$seat}'></div>";
			++$counter;

			if ($i == 2) { // For one seat at the front
				$seat_arrangement .= "</div>"; // Close cols for the seat at the front
				$counter = 0;
				$seat_arrangement .= "<div class='cols'>";
			}

			if ($i == 2) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			} elseif ($i == 6) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			} elseif ($i == 9) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			}

			//echo $i . ' - ' . $counter . '<br>';

			if ($counter == 4) {
				$counter = 0;
				$seat_arrangement .= "</div>"; // Close cols
			}
		}
		if ($counter == 1) $seat_arrangement .= "</div>";
		$seat_arrangement .= "\n</div>\n";

		return $seat_arrangement .= $this->lowerSittingDetails();
	}*/


	/**
	 *  Toyota hiace with seat number 10
	 *  one seats at the front
	 *  then three seats on other rows
	 */
	function getToyotaHiaceSeatsA()
	{
		$booked_seats = $this->booked_seats;
		$seat_arrangement = $this->upperSittingDetails('mini-bus');

		$counter = 0;
		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$class = "class='seat'";

			$seat = $i;
			if (in_array($seat, $booked_seats)) $class = "class='booked_seat'";
			if ($counter == 0) $seat_arrangement .= $i <= 2 ? "<div class='front-row'>" : "<div class='seat-row'>";

			$seat_arrangement .= "\t<div {$class} data-hidden='no'  title='Seat {$seat}' id='{$seat}'></div>";
			$counter++;

			if ($i == 2) { // For one seat at the front
				$seat_arrangement .= "</div>"; // Close cols for the seat at the front
				$counter = 0;
			}

			if ($i == 5) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			} elseif ($i == 8) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			} elseif ($i == 11) {
				$seat_arrangement .= "\t<div class='th-hide'></div>";
				$counter++;
			}

			if ($counter == 4) {
				$counter = 0;
				$seat_arrangement .= "</div>"; // Close cols
			}
		}
		if ($counter == 1) $seat_arrangement .= "</div>";
		$seat_arrangement .= "\n</div>\n";

		return $seat_arrangement .= $this->lowerSittingDetails();
	}


	function getNissianUrvanSeats()
	{
		$booked_seats = $this->booked_seats;
		$seat_arrangement = $this->upperSittingDetails('mini-bus nissian-urvan');

		$counter = 0;
		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$class = "class='seat'";

			$seat = $i;
			if (in_array($seat, $booked_seats)) $class = "class='booked_seat'";
			if ($counter == 0) $seat_arrangement .= $i <= 2 ? "<div class='front-row'>" : "<div class='seat-row'>";

			$seat_arrangement .= "\t<div {$class} data-hidden='no'  title='Seat {$seat}' id='{$seat}'></div>";
			$counter++;

			if ($i == 2) { // For one seat at the front
				$seat_arrangement .= "</div>"; // Close cols for the seat at the front
				$counter = 0;
			}

			if ($counter == 3) {
				$counter = 0;
				$seat_arrangement .= "</div>"; // Close cols
			}
		}
		if ($counter == 3) $seat_arrangement .= "</div>";
		$seat_arrangement .= "\n</div>\n";

		return $seat_arrangement .= $this->lowerSittingDetails();
	}


	public function getLuxurySeats()
	{
		//$booked_seats = $this->booked_seats;
		$seat_arrangement = $this->upperSittingDetails('luxury');

		$counter = $counter2 = 0;
		$seat_arrangement .= "<div id='right_seats'>";
		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$class = "class='seat'";

			if ($counter == 0) $seat_arrangement .= "<div class='cols'>";
			if ($counter < 2) {
				$seat = $i;
				if (in_array($seat, $this->booked_seats)) $class = "class='booked_seat'";
				$seat_arrangement .= "\t<div {$class} data-hidden='no' title='Seat {$seat}' id='{$seat}'></div>";
				++$counter;
				if ($counter == 2) $seat_arrangement .= "</div>"; // Close cols
				if ($i != $this->num_of_seats) { continue; }
			} else {
				if ($counter2 < 2) $down_seats[] = $i;
				++$counter2;
				if ($counter2 == 2) $counter2 = $counter = 0;
				if ($i != $this->num_of_seats) { continue; }
			}

			$counter = 0;
			$seat_arrangement .= "\n</div>\n<div id='left_seats'>\n";

			foreach ($down_seats AS $seat) {
				$class = "class='seat'";

				if ($counter == 0) $seat_arrangement .= "<div class='cols'>";
				if (in_array($seat, $this->booked_seats)) $class = "class='booked_seat'";
				$seat_arrangement .= "\t<div {$class} data-hidden='no' title='Seat {$seat}' id='{$seat}'></div>";
				++$counter;
				if ($counter == 2) {
					// Close cols
					$seat_arrangement .= "</div>";
					$counter = 0;
				}
			}
			if ($counter == 1) $seat_arrangement .= "</div>";
			$seat_arrangement .= "\n</div>\n</div>";
		}

		return $seat_arrangement .= $this->lowerSittingDetails();
	}


	private function upperSittingDetails($vehicle_type)
	{
		return "<div class='seat_arrangement $vehicle_type' data-fare='{$this->fare}' data-park_map_id='{$this->park_map_id}' data-trip_id='{$this->trip_id}'
		data-boarding_vehicle_id='{$this->boarding_vehicle_id}' data-vehicle_type_id='{$this->vehicle_type_id}' data-travel_date='{$this->travel_date}' data-departure_time='{$this->departure_time}' data-departure_order='{$this->departure_order}'>
		<span class='glyphicon glyphicon-remove pull-right'></span>
		<div class='text-center'>Click on an available seat to select it. Click again to de-select it.</div>
		<div class='row'>
			<div class='col-md-6 col-xs-6'>
				<div class='seat_wrap'>
					<div class='cols steering'></div>";
	}


	private function lowerSittingDetails()
	{
		return "\n</div>
		<div class='col-md-6 col-xs-6'>
			<div class='seat-tips'>\n
				<ul>\n
					\t<p><li class='steering-wheel'>Steering Wheel</li></p>\n
					\t<li class='available_seat'>Available Seat</li>\n
					\t<li class='selected_seat'>Selected Seat</li>\n
					\t<li class='booked-seat'>Booked Seat</li>\n
				</ul>\n
			</div>

			<span id='seat_details' class='seat-details'>
				Seat number: <span class='picked_seat'></span><br>
				Fare: <span class='show_fare red'></span>
			</span>

			<span class='continue-btn pull-right'>
				<button class='continue btn btn-warning btn-fill btn-sm pull-right'>&nbsp; <i class='fa fa-caret-right'></i> Continue &nbsp;<i class='fa fa-angle-double-right'></i></button>
			</span>
		</div>
		</div>";
	}
}
?>
