<?php
session_start();

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
        $params['account_number'] = $_POST['account_number'];
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
    elseif ($_POST['op'] == 'update-park')
    {
        require_once "../api/models/parkmodel.class.php";
        $id = $_POST['id'];
        $name = $_POST['name'];
        $park_model = new ParkModel();

        if ($park_model->updatePark($name, $id)) {
            echo "Done";
        }
    }
    elseif ($_POST['op'] == "admin-bookings-report")
    {
        require_once "../api/models/reportmodel.class.php";
        $report_model = new Report();
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date =  date('Y-m-d', strtotime($_POST['end_date']));
        $mode = $_POST['mode'];
        $type = $_POST['type'];
        $reports = array();
        if ($type == "bookings") {
            $reports = $report_model->adminGetBooking($mode, $start_date, $end_date);
        }

        echo json_encode($reports);
    }
    elseif ($_POST['op'] == "travel-bookings-report")
    {
        require_once "../api/models/reportmodel.class.php";
        $report_model = new Report();
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date =  date('Y-m-d', strtotime($_POST['end_date']));
        $mode = $_POST['mode'];
        $type = $_POST['type'];
        $travel_id = $_SESSION['travel_id'];
        $reports = array();
        if ($type == "bookings") {
            $reports = $report_model->travelGetBooking($travel_id, $mode, $start_date, $end_date);
        }

        echo json_encode($reports);
    }
    elseif ($_POST['op'] == "state-bookings-report")
    {
        require_once "../api/models/reportmodel.class.php";
        $report_model = new Report();
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date =  date('Y-m-d', strtotime($_POST['end_date']));
        $mode = $_POST['mode'];
        $type = $_POST['type'];
        $state_id = $_SESSION['state_id'];
        $reports = array();
        if ($type == "bookings") {
            $reports = $report_model->stateGetBooking($_SESSION['travel_id'], $state_id, $mode, $start_date, $end_date);
        }

        echo json_encode($reports);
    }
    elseif ($_POST['op'] == "park-bookings-report")
    {
        require_once "../api/models/reportmodel.class.php";
        $report_model = new Report();
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date =  date('Y-m-d', strtotime($_POST['end_date']));
        $mode = $_POST['mode'];
        $type = $_POST['type'];
        $park_id = $_SESSION['park_id'];
        $reports = array();
        if ($type == "bookings") {
            $reports = $report_model->parkGetBooking($_SESSION['travel_id'], $park_id, $mode, $start_date, $end_date);
        }

        echo json_encode($reports);
    }
    elseif ($_POST['op'] == "update-fare")
    {
        require_once "../api/models/trip.class.php";
        $trip_model = new Trip();

        $trips_data = $_POST['trips'];
        foreach ($trips_data as $trip_data) {
            $trip_model->updateFare($trip_data['trip_id'], $trip_data['fare']);
        }
        echo "Done";
    }
}
