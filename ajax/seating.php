<?php
session_start();
require_once "../classes/seatpicker.class.php";

extract($_POST);
$seatpicker = new SeatPicker($route_id, $travel_date, $num_of_seats, $bus_type_id, $fare, $fare_id);
echo $seatpicker->getSeatChart();
?>
