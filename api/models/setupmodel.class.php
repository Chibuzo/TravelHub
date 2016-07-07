<?php
require_once "model.class.php";

class SetupModel extends Model {

	function __construct()
	{
		parent::__construct();
	}
	
	
	public function getTravelDetails($travel_id, $park_id)
    {
        // get park name
        $sql = "SELECT park FROM parks WHERE id = :id";
        self::$db->query($sql, array('id' => $park_id));
        if ($park = self::$db->fetch('obj')) {
            //return $park->id;
        } else {
            throw new Exception("Park not found", "00");
        }
        $travel = new Travel();
        $details = $travel->getTravel($travel_id);
        $details->park = $park->park;
        return $details;
    }


    public function getWorkingData($travel_id, $park_id)
    {
        $data = array();

        // get travel vehicle types
        $travelVehicle = new TravelVehicle();
        $data['vehicles'] = $travelVehicle->getAllVehicleTypes($travel_id);

        // get all routes from a park
        $park_map = new TravelParkMap();
        $data['destinations'] = $park_map->getParkMap($travel_id, $park_id);

        // get trips
        $trip = new Trip();
        $data['trips'] = $trip->getByParkTravel($park_id, $travel_id);

        return $data;
    }


    public function addParkMap($origin, $destination, $travel_id)
    {
        $travelParkMap = new TravelParkMap();
        return $travelParkMap->addParkMap($origin, $destination, $travel_id);
    }


    public function addTrip($park_map_id, $departure, $travel_id, $state_id, $vehicle_type_id, $amenities, $departure_time, $fare)
    {
        $data = array();
        $travelParkMap = new TravelParkMap();
        $route = $travelParkMap->getRoute($park_map_id);
        $data['route_id'] = $route->id;
        $trip = new Trip();
        $data['trip_id'] = $trip->addTrip($park_map_id, $departure, $travel_id, $state_id, $route->id, $vehicle_type_id, $amenities, $departure_time, $fare);
        return $data;
    }


    public function updateTrip($trip_id, $amenities, $fare)
    {
        $trip = new Trip();
        if ($trip->updateTrip($trip_id, $amenities, $fare)) {
            return true;
        }
        return false;
    }
}