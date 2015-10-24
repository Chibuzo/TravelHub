<?php
session_start();

extract($_POST);
$_SESSION['bus_id']          = $bus_id;
$_SESSION['seat_no']         = $seat_no;
$_SESSION['boarding_bus_id'] = isset($_POST['boarding_bus_id']) ? $boarding_bus_id : null;
$_SESSION['fare']            = $fare;
$_SESSION['travel_date']     = $travel_date;
$_SESSION['num_of_seats']    = $num_of_seats;
?>
