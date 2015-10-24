<?php


if (isset($_REQUEST['op'])) {
	if ($_POST['op'] == 'cancel-reservation')
	{
		require_once "../api/models/bookingmodel.class.php";
		$book = new BookingModel();
		if ($book->cancelBooking($_POST['id']) === true) {
			echo "Done";
		}
	}
	elseif ($_POST['op'] == 'delete-vehicle_type') {
		require_once "../api/models/busmodel.class.php";
		$bus = new BusModel();
		if ($bus->removeVehicle($_POST['id']) === true) {
			echo "Done";
		}
	}
	elseif ($_POST['op'] == "remove-route") {
		require_once "../api/models/routemodel.class.php";
		$route = new RouteModel();
		if ($route->removeRoute($_POST['id']) === true) {
			echo "Done";
		}
	}
	elseif ($_POST['op'] == 'update-route')
	{
		require_once "../api/models/routemodel.class.php";
		$route = new RouteModel();
		if ($route->editRoute($_POST['origin'], $_POST['destination'], $_POST['id']) === true) {
			echo "Done";
		}
	}
	elseif ($_POST['op'] == 'update-bus')
	{
		require_once "../api/models/busmodel.class.php";
		$bus = new BusModel();
		extract($_POST);
		if ($bus->updateBusType($name, $num_of_seat, $id) === true) {
			echo "Done";
		}
	}
}
?>
