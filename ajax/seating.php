<?php
session_start();
require_once "../classes/seatpicker.class.php";

extract($_POST);
$seatpicker = new SeatPicker($park_map_id, $travel_date, $num_of_seats, $vehicle_type_id, $fare, $trip_id, $travel_id, $departure_order);
echo $seatpicker->getSeatChart();
