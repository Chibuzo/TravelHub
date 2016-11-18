<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_REQUEST['op'])) {
    if ($_REQUEST['op'] == 'get-travel-state-parks')
    {
        require_once "../api/models/parkmodel.class.php";
        require_once "../api/models/travelparkmap.class.php";
        $parkModel = new ParkModel();
        $travelParkMap = new TravelParkMap();

        $parks = $parkModel->getTravelParksByState($_POST['travel_id'], $_POST['state_id']);
        $tbody = "";
        foreach ($parks AS $park) {
            $status = $park->status == 1 ? 'Checked' : '';
            $online = $park->online == 1 ? 'Checked' : '';
            $tbody .= "<tr id='{$park->park_id}' data-park='{$park->park}'>
                        <td>$park->park</td>
                        <td class='text-right'>" . $travelParkMap->getNumOfRoutesForPark($_POST['travel_id'], $park->park_id) . "</td>
                        <td>
                            <div class='onoffswitch'>
                                <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$park->park}-status' data-level='park' data-field='status' $status>
                            </div>
                        </td>
                        <td>
                            <div class='onoffswitch'>
                                <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$park->park}-online' data-level='park' data-field='online' $online>
                            </div>
                        </td>
                        <td>{$park->address} <br> {$park->phone}</td>
                        <td class='dropdown'>
                            <a href='' class='btn btn-default btn-xs' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' title='Configuration'><i class='fa fa-cogs fa-lg'></i></a>
                            <ul class='dropdown-menu'>
                                <li class='dropdown-header'>{$park->park} Configuration Settings</li>
                                <li><a href='#' class='manage-route' data-toggle='modal' data-target='#manageRouteModal'>Manage Routes</a></li>
                                <li><a href='#' class='manage-trips' data-toggle='modal' data-target='#manageTripsModal'>Manage Trips</a></li>
                            </ul>
                        </td>
                     </tr>";
        }

        echo $tbody;
    }
    elseif ($_REQUEST['op'] == 'add-trip')
    {
        require_once "../api/models/trip.class.php";
        require_once "../api/models/travelparkmap.class.php";
        $trip = new Trip();
        $travelParkMap = new TravelParkMap();
        extract($_POST);
        $amenities = implode($amenities, ">");
        $departureTime = $hour . ":" . $minute . ":00";
        $route = $travelParkMap->getRoute($park_map_id);
        $trip->addTrip($park_map_id, $departure_order, $travel_id, $route->origin, $route->id, $vehicle_type_id, $amenities, $departureTime, $fare, 'ignore-push');
    }
    elseif ($_REQUEST['op'] == 'update-trip')
    {
        require_once "../api/models/trip.class.php";
        require_once "../api/models/travelparkmap.class.php";
        $trip = new Trip();
        extract($_POST);
        $amenities = implode($amenities, ">");
        $departureTime = $hour . ":" . $minute . ":00";
        $trip->updateTrip($trip_id, $amenities, $fare, $departure_order, $departureTime);
    }
    elseif ($_REQUEST['op'] == 'get-travel-vehicles-routes')
    {
        require_once "../api/models/travelvehicle.class.php";
        require_once "../api/models/travelparkmap.class.php";
        $travelVehicle = new TravelVehicle();
        $travelParkMap = new TravelParkMap();
        $data = array();
        $data['vehicles'] = $travelVehicle->getAllVehicleTypes($_POST['travel_id']);
        $data['park_maps'] = $travelParkMap->getTravelParkParkMaps($_POST['travel_id'], $_POST['park_id']);
        echo json_encode($data);
    }
    elseif ($_REQUEST['op'] == 'get-park-trips')
    {
        require_once "../api/models/trip.class.php";
        $trip = new Trip();
        $trips = $trip->getByParkTravel($_POST['park_id'], $_POST['travel_id']);
        echo json_encode($trips);
    }
    elseif ($_REQUEST['op'] == 'alter-state-setting')
    {
        require_once "../api/models/travel.class.php";
        $travel = new Travel();
        $travel->updateStateSetting($_POST['travel_id'], $_POST['state_id'], $_POST['field'], $_POST['value']);
    }
    elseif ($_REQUEST['op'] == 'alter-park-setting')
    {
        require_once "../api/models/travel.class.php";
        $travel = new Travel();
        $travel->updateParkSetting($_POST['travel_id'], $_POST['park_id'], $_POST['field'], $_POST['value']);
    }
    elseif ($_REQUEST['op'] == 'add-travel-admin')
    {
        $params['company_name'] = $_POST['company_name'];
        $params['abbr'] = $_POST['abbr'];
        $params['online_charge'] = $_POST['online_charge'];
        $params['offline_charge'] = $_POST['offline_charge'];
        $params['api_charge'] = $_POST['api_charge'];

        try {
            $result = $travel_model->saveTravel($params);
            if ($result == false) {
                echo "There was an error, travel was not added.";
            } else {
                echo "Done";
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    elseif ($_REQUEST['op'] == 'add_travel_vehicle_type')
    {
        require_once "../api/models/travelvehicle.class.php";
        $travelVehicle = new TravelVehicle();
        extract($_POST);
        $travelVehicle->addVehicleType($travel_id, $vehicle_name, $vehicle_type_id, $num_of_seats, 'ignore-push');
    }
    elseif($_REQUEST['op'] == 'get-travel-vehicle-types')
    {
        require_once "../api/models/travelvehicle.class.php";
        $travelVehicle = new TravelVehicle();
        $vehicles = $travelVehicle->getAllVehicleTypes($_POST['travel_id']);
        echo json_encode($vehicles);
    }
}