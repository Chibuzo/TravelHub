<?php
session_start();

extract($_POST);
$_SESSION['vehicle_type_id'] = $vehicle_type_id;
$_SESSION['seat_no']         = $seat_no;
$_SESSION['boarding_vehicle_id'] = $boarding_vehicle_id;
$_SESSION['fare']            = $fare;
$_SESSION['trip_id']         = $trip_id;
$_SESSION['travel_date']     = $travel_date;
$_SESSION['departure_order'] = $departure_order;
$_SESSION['departure_time']  = $departure_time;
//$_SESSION['num_of_seats']    = $num_of_seats;
