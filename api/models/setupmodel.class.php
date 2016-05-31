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

        // get park admin

        // get all routes from a park
        $park_map = new TravelParkMap();
        $data['destinations'] = $park_map->getParkMap($travel_id, $park_id);

        // get trips
        $trip = new Trip();
        $data['trips'] = $trip->getByParkTravel($park_id, $travel_id);

        return $data;
    }
}