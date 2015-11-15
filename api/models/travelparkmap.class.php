<?php
require_once "parkmodel.class.php";

class TravelParkMap extends ParkModel {

	public $id, $travel_id, $route_id, $status;
	protected static $tbl = "travel_park_map";

	function __construct()
	{
		parent::__construct();
	}


	public function addParkMap($origin, $destination, $travel_id)
	{
		$park_map_id = parent::addParkMap($origin, $destination);

		// check if the route has been added already
		if (is_numeric($this->verifyParkMap($park_map_id, $travel_id))) {
			return true;
		}

		$sql = "INSERT INTO " . self::$tbl . " (travel_id, park_map_id) VALUES (:travel_id, :park_map_id)";
		$param = array(
			'travel_id' =>$travel_id,
			'park_map_id' => $park_map_id
		);
		if (self::$db->query($sql, $param)) {
			return self::$db->getLastInsertId();
		}
	}

    /**
     * Returns all park_maps for a travel irrespective of destination and origin
     *
     * @param $travel_id
     * @return mixed
     */
    public function getTravelParkMaps($travel_id)
    {
        $sql = "SELECT pm.*, d.park AS destination_name, o.park AS origin_name, states.state_name as destination_state
                FROM park_map AS pm
                INNER JOIN travel_park_map ON travel_park_map.park_map_id = pm.id
                INNER JOIN parks AS d ON pm.destination = d.id
                INNER JOIN parks AS o ON pm.origin = o.id
                INNER JOIN states ON d.state_id = states.id
                WHERE travel_park_map.travel_id = :travel_id AND travel_park_map.status = '0'";
        self::$db->query($sql, array('travel_id' => $travel_id));
        return self::$db->fetchAll('obj');
    }

    /**
     * Returns all park_maps from an originating state for a particular travel
     *
     * @param $travel_id
     * @param $state_id - state_id for originating state
     * @return mixed
     */
    public function getTravelStateParkMaps($travel_id, $state_id)
    {
        $sql = "SELECT pm.*, d.park AS destination_name, o.park AS origin_name, state.state_name as origin_state, d_s.state_name as destination_state
                FROM park_map AS pm
                INNER JOIN travel_park_map ON travel_park_map.park_map_id = pm.id
                INNER JOIN parks AS d ON pm.destination = d.id
                INNER JOIN parks AS o ON pm.origin = o.id
                INNER JOIN states AS state ON o.state_id = state.id
                INNER JOIN states AS d_s ON d.state_id = d_s.id
                WHERE travel_park_map.travel_id = :travel_id AND travel_park_map.status = '0' AND state.id = :state_id";
        self::$db->query($sql, array('travel_id' => $travel_id, 'state_id'=> $state_id));
        return self::$db->fetchAll('obj');
    }


    /**
     * Returns all the park_maps for a route
     *
     * @param $origin - state_id for the originating state
     * @param $destination - state_id for the destination state
     * @return mixed
     */
    public function getParkMapByRoute($origin, $destination)
    {
        $sql = "SELECT pm.*, d.park AS destination_name, o.park AS origin_name, d_s.state_name AS destination_state, o_s.state_name AS origin_state
                FROM park_map AS pm
                INNER JOIN travel_park_map ON travel_park_map.park_map_id = pm.id
                INNER JOIN parks AS d ON pm.destination = d.id
                INNER JOIN parks AS o ON pm.origin = o.id
                INNER JOIN states AS o_s ON o.state_id = o_s.id
                INNER JOIN states AS d_s ON d.state_id = d_s.id
                WHERE o_s.id = :origin AND d_s.id = :destination";
        self::$db->query($sql, array('origin' => $origin, 'destination'=> $destination));
        return self::$db->fetchAll('obj');
    }

	public function verifyParkMap($park_map_id, $travel_id)
	{
		$sql = "SELECT id FROM " . self::$tbl . " WHERE park_map_id = :park_map_id AND travel_id = :travel_id";
		$param = array(
			'travel_id' => $travel_id,
			'park_map_id' => $park_map_id
		);
		self::$db->query($sql, $param);
		if ($id = self::$db->fetch('obj')) {
			return $id->id;
		}
	}


	public function disableRoute($route_id, $travel_id)
	{
		$sql = "UPDATE " . self::$tbl . " SET status = '0' WHERE route_id = :route_id AND travel_id = :travel_id";
		if (self::$db->query($sql, array('route_id' => $route_id, 'travel_id' => $travel_id))) {
			return true;
		}
	}


	public function removeRoute($route_id, $travel_id)
	{
		$sql = "UPDATE " . self::$tbl . " SET removed = '1' WHERE route_id = :route_id AND travel_id = :travel_id";
		if (self::$db->query($sql, array('route_id' => $route_id, 'travel_id' => $travel_id))) {
			return true;
		}
	}
}
?>
