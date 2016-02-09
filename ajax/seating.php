<?php
session_start();
require_once "../classes/seatpicker.class.php";

extract($_POST);
$seatpicker = new SeatPicker($route_id, $travel_date, $num_of_seats, $vehicle_type_id, $fare, $trip_id);
echo $seatpicker->getSeatChart();
