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
		require_once "../api/models/vehiclemodel.class.php";
		$bus = new VehicleModel();
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
		require_once "../api/models/vehiclemodel.class.php";
		$bus = new VehicleModel();
		extract($_POST);
		if ($bus->updateVehicleType($name, $num_of_seat, $id) === true) {
			echo "Done";
		}
	}
    elseif ($_POST['op'] == 'update-travel')
    {
        require_once "../api/models/travel.class.php";
        $travel_model = new Travel();

        $params['id'] = $_POST['id'];
        $params['company_name'] = $_POST['company_name'];
        $params['online_charge'] = $_POST['online_charge'];
        $params['offline_charge'] = $_POST['offline_charge'];
        try {
            $result = $travel_model->saveTravel($params);
            if ($result == false) {
                $msg = "There was an error, travel was not updated.";
            }
        } catch (\Exception $e) {

        }
        echo "Done";
    }
    elseif ($_POST['op'] == 'travel-details')
    {
        $id = $_POST['id'];
        require_once "../cp/admin/mini-pages/travel-detail.php";
    }
    elseif ($_POST['op'] == 'add-travel-admin')
    {
        require_once "../api/models/user.class.php";
        $user_model = new User();
        $result = $user_model->createUser($_POST['full_name'], $_POST['username'], $_POST['password'], 'travel_admin');
        if ($result != false) {
            $user_model->linkUserToTravel($_POST['travel_id'], $result);
            echo "Done";
        }
    }
    elseif ($_POST['op'] == 'park-details')
    {
        $id = $_POST['id'];

        require_once "../includes/db_handle.php";
        require_once "../cp/state/mini-pages/park-detail.php";
    }
    elseif ($_POST['op'] == "get-state-parks")
    {
        $id = $_POST['state_id'];
        require_once "../api/models/parkmodel.class.php";
        $park_model = new ParkModel();

        $parks =  $park_model->getParksByState($id);

        echo json_encode($parks);
        exit;
    }
}
?>
