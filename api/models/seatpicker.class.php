<?php
require_once "../api/models/model.class.php";

class SeatPicker extends Model {
	public $bus_id;
	public $fare;
	public $fare_id;
	public $travel_date;
	public $route_id;
	public $num_of_seats;
	public $boarding_bus_id = null;
	public $booked_seats;
	public $seat_status;
	public $departure_time = '';
	//public $departure_order = 1;

	private $tbl = 'boarding_bus';

	function __construct($route_id, $travel_date, $num_of_seats, $bus_id, $fare, $fare_id)
	{
		parent::__construct();

		//$this->route_id = $route_id;
		$this->travel_date = $travel_date;
		$this->num_of_seats = $num_of_seats;
		$this->bus_id = $bus_id;
		$this->fare = $fare;
		$this->fare_id = $fare_id;
	}


	function getSeatChart()
	{
		$this->getBoardingBusDetails();

		switch ($this->num_of_seats) {
			case 3:
			case 5:
				return $this->getSiennaSeats();
				break;
			//case 3:
				//return $this->getCarSeats();
				//break;
			case 10:
				return $this->getBusSeats();
				break;
			case 19:
				return $this->getCoaterSeats();
				break;
		}
	}


	function getBoardingBusDetails()
	{
		$sql = "SELECT id, booked_seats, seat_status FROM {$this->tbl}
				WHERE fare_id = :fare_id
				AND travel_date = :travel_date";

		$param = array(
			'fare_id' => $this->fare_id,
			'travel_date' => $this->travel_date
		);

		$this->db->query($sql, $param);
		if ($bus = $this->db->fetch('obj')) {
			$this->boarding_bus_id = $bus->id;
			$this->booked_seats = explode(',', $bus->booked_seats);
			$this->seat_status =  $bus->seat_status;
		} else {
			$this->boarding_bus_id = $this->insertBusForBoarding();
			$this->booked_seats = array();
			$this->seat_status = 'Not full';
		}
	}


	private function insertBusForBoarding()
	{
		// add bus for boarding
		$sql = "INSERT INTO {$this->tbl}
					(fare_id, travel_date)
				VALUES
					(:fare_id, :travel_date)";

		$param = array(
			'fare_id' => $this->fare_id,
			'travel_date' => $this->travel_date
		);

		if ($this->db->query($sql, $param))
			return $this->db->getLastInsertId();
	}


	/**
	 *  Toyota hiace or Nissian urvan with seat number 10
	 *  one seats at the front
	 *  then three seats on other rows
	 */
	function getBusSeats()
	{
		$booked_seats = $this->booked_seats;
		$width = '410px';
		$style = "width: 110px; float: left; text-align: left; margin-top: 25px";
		$steering_pos = "height:78px"; // set steering position

		$seat_arrangement = $this->upperSittingDetails($width, $steering_pos);

		$counter = 0;
		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$class = "class='seat'";

			$seat = $i;
			if (in_array($seat, $booked_seats)) $class = "class='booked_seat'";
			/*** exchange arrays to match seating arrangement for second row ***/

			//if ($counter == 0 && $this->num_of_seats > 14 && $i != 12) $seat_arrangement .= "<div class='cols'><div style='width:20px; height:18px; margin:6px;'></div>";
			if ($counter == 0) $seat_arrangement .= "<div class='cols'>";
			$seat_arrangement .= "\t<div {$class} data-hidden='no' title='Seat {$seat}' id='{$seat}'></div>";
			++$counter;

			if ($i == 1) { // For one seat at the front
				$seat_arrangement .= "</div>"; // Close cols for the seat at the front
				$counter = 0;
			}

			if ($counter == 3) {
				//if ($i == 10) { $counter = 1; continue; }
				$counter = 0;
				$seat_arrangement .= "</div>"; // Close cols
			}
		}
		if ($counter == 1) $seat_arrangement .= "</div>";
		$seat_arrangement .= "\n</div>\n";

		return $seat_arrangement .= $this->lowerSittingDetails($style);
	}


	function getSiennaSeats() {
		$booked_seats = $this->booked_seats;
		$width = '420px';
		$style = "width: 110px; float: left; margin-top: 25px";
		$steering_pos = "height:62px"; // set steering position

		$seat_arrangement = $this->upperSittingDetails($width, $steering_pos);

		$counter = 0;
		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$seat = $i; $class = '';

			// rearrange seat number
			if ($i > 1) {
				if ($i % 2 == 0) $seat = $i + 1;
				else {
					$seat = $i - 1;
					$class .= ' push-seat';
				}
			}
			if (in_array($seat, $booked_seats)) $class .= " booked_seat";
			else $class .= " seat";

			if ($counter == 0) $seat_arrangement .= "<div class='cols'>";
			$seat_arrangement .= "\t<div class='{$class}' data-hidden='no' title='Seat {$seat}' id='{$seat}'></div>";
			++$counter;

			if ($i == 1) { // For one seat at the front
				$seat_arrangement .= "</div>"; // Close cols for the seat at the front
				$counter = 0;
			}

			if ($counter == 2) {
				//if ($i == 10) { $counter = 1; continue; }
				$counter = 0;
				$seat_arrangement .= "</div>"; // Close cols
			}
		}
		//if ($counter == 1) $seat_arrangement .= "</div>";
		$seat_arrangement .= "\n</div>\n";

		return $seat_arrangement .= $this->lowerSittingDetails($style);
	}



	/*** Seating arrangement for 59/60 seater bus ***/
	function getCoaterSeats() {
		$width = '470px';
		$style = "position:relative; top:4px; width:150px; right:6px; clear: both; display:block";
		$counter = 0; $counter2 = 0;

		$seat_arrangement = "<div class='seat_arrangement' style='width:{$width}' data-fare='{$this->fare}' data-route_id='$this->route_id'
		data-num_of_seats='{$this->num_of_seats}' data-boarding_bus_id='$this->boarding_bus_id' data-travel_date='{$this->travel_date}'>
		<span class='glyphicon glyphicon-remove pull-right'></span>
		<p>Click on an available seat to select it. Click again to de-select it.</p>
		<div class='seat_wrap' style='margin-left:30px; display:inline'>
		<div id='right_seats'>\n<div class='cols steering'></div>\n";

		for ($i = 1; $i <= $this->num_of_seats; $i++) {
			$class = "class='seat'";

			if ($counter == 0) $seat_arrangement .= "<div class='cols'>";
			if ($counter < 2) {
				/*** exchange arrays to match seating arrangement ***/
				if ($i % 2 == 1) $seat = $i + 1;
				else $seat = $i - 1;
				if (in_array($seat, $this->booked_seats)) $class = "class='booked_seat'";
				$seat_arrangement .= "\t<div {$class} data-bus_id='{$this->bus_id}' data-hidden='no' title='Seat {$seat}' id='{$seat}'></div>";
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
			$seat_arrangement .= "\n</div>\n<div id='left_seats' style='margin-top:10px'><div class='cols'></div>\n";

			foreach ($down_seats AS $seat) {
				$class = "class='seat'";

				if ($seat % 2 == 1) ++$seat;
				else --$seat;
				//if ($this->num_of_seats == 59 && $seat == 60) $seat = 59;		// Fixes a bug that makes the last seat 60 instead of 59 due to the rearrangement
				if ($counter == 0) $seat_arrangement .= "<div class='cols'>";
				if (in_array($seat, $this->booked_seats)) $class = "class='booked_seat'";
				$seat_arrangement .= "\t<div {$class} data-bus_id='{$this->bus_id}' data-hidden='no' title='Seat {$seat}' id='{$seat}'></div>";
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

		return $seat_arrangement .= $this->lowerSittingDetails($style);
	}


	private function upperSittingDetails($width, $steering_pos)
	{
		return "<div class='seat_arrangement' style='width:$width' data-fare='{$this->fare}' data-route_id='{$this->route_id}'
		data-boarding_bus_id='{$this->boarding_bus_id}' data-bus_id='{$this->bus_id}' data-travel_date='{$this->travel_date}'>
		<span class='glyphicon glyphicon-remove pull-right'></span>
		<p>Click on an available seat to select it. Click again to de-select it.</p><div class='seat_wrap'>
		<div class='cols steering' style='{$steering_pos}; left:9px'></div>";
	}


	private function lowerSittingDetails($style)
	{
		return "\n<div id='seat_tips'>\n<ul>\n
		\t<p><li id='available_seat'>Available Seat</li></p>\n
		\t<p><li id='selected_seat'>Selected Seat</li></p>\n
		\t<p><li id='booked_seat'>Booked Seat</li></p>\n
		</ul>\n</div>
		<span style='{$style}' id='seat_details'>
			Seat number: <span class='picked_seat'></span><br />
			Fare: <span class='show_fare red'></span>
		</span>

		<div style='clear: both; position: relative; top: -25px; right: 15px;'>
			<a href='' style='margin-top: -10px' class='continue btn btn-primary pull-right'>Continue</a>
		</div></div>";
	}
}
?>
