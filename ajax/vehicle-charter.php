<?php
require_once "../api/models/VehicleCharter.class.php";

$charter = new VehicleCharter();

if (isset($_REQUEST['op'])) {
	if ($_REQUEST['op'] == 'add-charter')
	{
		extract($_POST);
		if ($charter->addCharter($c_name, $c_phone, $email, $trip_date, $origin, $destination, $vehicle_type, $num_of_vehicles)) {
			echo "Done";
		}
	}
	elseif ($_REQUEST['op'] == 'cancel-charter')
	{
		if ($charter->cancel($_POST['id'])) {
			echo "Done";
		}
	}
	elseif ($_REQUEST['op'] == 'confirm-charter')
	{
		if ($charter->confirm($_POST['id'])) {
			echo "Done";
		}
	}
}
?>