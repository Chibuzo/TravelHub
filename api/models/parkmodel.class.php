<?php
require_once "model.class.php";

class ParkModel extends Model {

	protected static $tbl = "park_map";

	function __construct() {
		parent::__construct();
	}

    function addPark($park_name, $state_id)
    {
        if (!$this->getParkByName($park_name, $state_id)) {
            $sql = "INSERT INTO parks (state_id, park) VALUES (:state_id, :park)";
            if (self::$db->query($sql, array('state_id' => $state_id, 'park' => $park_name))) {
                return self::$db->getLastInsertId();
            }
        }
        return false;
    }

    function updatePark($park_name, $id)
    {
        $sql = "UPDATE parks SET park = :park WHERE id = :id";
        if (self::$db->query($sql, array('park' => $park_name, 'id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    function getStates()
    {
        $sql = "SELECT id, state_name FROM states ORDER BY state_name";
        self::$db->query($sql);
        return self::$db->fetchAll('obj');
    }

    function getState($state_id)
    {
        $sql = "SELECT id, state_name FROM states WHERE id = :id";
        self::$db->query($sql, array('id' => $state_id));
        return self::$db->fetch('obj');
    }

    function getPark($id, $state_id)
    {
        $sql = "SELECT parks.id AS id, parks.park AS park, states.id AS state_id, states.state_name AS state_name
                FROM parks
                INNER JOIN states ON parks.state_id = states.id
                WHERE parks.id = :id AND parks.state_id = :state_id";
        self::$db->query($sql, array('id' => $id, 'state_id' => $state_id));
        return self::$db->fetch('obj');
    }

    function getParkById($id)
    {
        $sql = "SELECT parks.id AS id, parks.park AS park, states.id AS state_id, states.state_name AS state_name
                FROM parks
                INNER JOIN states ON parks.state_id = states.id
                WHERE parks.id = :id";
        self::$db->query($sql, array('id' => $id));
        return self::$db->fetch('obj');
    }

    function getParkByName($park_name, $state_id)
    {
        $sql = "SELECT parks.id AS id, parks.park AS park, states.id AS state_id, states.state_name AS state_name
                FROM parks
                INNER JOIN states ON parks.state_id = states.id
                WHERE parks.park = :park_name AND parks.state_id = :state_id";
        self::$db->query($sql, array('park_name' => $park_name, 'state_id' => $state_id));
        return self::$db->fetch('obj');
    }

	function getParks()
	{
        $sql = "SELECT parks.id AS id, parks.park AS park, states.id AS state_id, states.state_name AS state_name
                FROM parks
                INNER JOIN states ON parks.state_id = states.id";
        self::$db->query($sql);
        return self::$db->fetchAll('obj');
	}


    function getParksByState($state_id)
    {
        $sql = "SELECT parks.id AS id, parks.park AS park, states.id AS state_id, states.state_name AS state_name
                FROM parks
                INNER JOIN states ON parks.state_id = states.id
                WHERE parks.state_id = :state_id";
        self::$db->query($sql, array('state_id' => $state_id));
        return self::$db->fetchAll('obj');
    }

    function getTravelParks($travel_id)
    {
        $sql = "SELECT travel_park.id, travel_park.travel_id AS travel_id, parks.park, states.state_name AS state_name, states.id AS state_id, users.fullname, users.username, users.id AS user_id
                FROM travel_park
                INNER JOIN parks ON travel_park.park_id = parks.id
                INNER JOIN users ON travel_park.user_id = users.id
                INNER JOIN states ON states.id = parks.state_id
                WHERE travel_park.travel_id = :travel_id";
        self::$db->query($sql, array('travel_id' => $travel_id));
        return self::$db->fetchAll('obj');
    }

    function getTravelParksByState($travel_id, $state_id)
    {
        $sql = "SELECT travel_park.id, travel_park.travel_id AS travel_id, parks.park, parks.id AS park_id, users.fullname, users.username, users.id AS user_id, states.state_name AS state_name
                FROM travel_park
                INNER JOIN parks ON travel_park.park_id = parks.id
                INNER JOIN users ON travel_park.user_id = users.id
                INNER JOIN states ON parks.state_id = states.id
                WHERE travel_park.travel_id = :travel_id AND parks.state_id = :state_id";
        self::$db->query($sql, array('travel_id' => $travel_id, 'state_id' => $state_id));
        return self::$db->fetchAll('obj');
    }

    function getTravelParksByPark($travel_id, $park_id)
    {
        $sql = "SELECT travel_park.id, travel_park.travel_id AS travel_id, parks.park, parks.id AS park_id, users.fullname, users.username, users.id AS user_id, states.state_name AS state_name
                FROM travel_park
                INNER JOIN parks ON travel_park.park_id = parks.id
                INNER JOIN users ON travel_park.user_id = users.id
                INNER JOIN states ON parks.state_id = states.id
                WHERE travel_park.travel_id = :travel_id AND parks.id = :park_id";
        self::$db->query($sql, array('travel_id' => $travel_id, 'park_id' => $park_id));
        return self::$db->fetch('obj');
    }

	public function checkParkMapExist($origin, $destination)
	{
		$sql = "SELECT id FROM " . self::$tbl . " WHERE origin = :origin AND destination = :destination";
		$param = array('origin' => $origin, 'destination' => $destination);
		self::$db->query($sql, $param);
		if ($id = self::$db->fetch('obj')) {
			return $id->id;
		} else {
			return false;
		}
	}

	public function addParkMap($origin, $destination)
	{
		$park_map_id = $this->checkParkMapExist($origin, $destination);
		if (is_numeric($park_map_id)) {
			return $park_map_id;
		}

		$sql = "INSERT INTO park_map (origin, destination) VALUES (:origin, :destination)";
		$param = array(
			'origin' => $origin,
			'destination' => $destination
		);
		if (self::$db->query($sql, $param)) {
			return self::$db->getLastInsertId();
		}
	}


	/*public function getAllRoutes()
	{
		return parent::getManyById('routes', 'status', 1, 'route');
	}


	public function getDestination($origin)
	{
		return parent::getManyById('routes', 'origin', $origin, 'destination');
	}

	public function editRoute($origin, $destination, $id)
	{
		$sql = "UPDATE park_map SET
					origin = :origin,
					destination = :destination
				WHERE id = :id";

		$param = array(
			'origin' => $origin,
			'destination' => $destination,
			'id' => $id
		);
		if (self::$db->query($sql, $param)) {
			return true;
		}
	}*/

	public function removeParkMap($id)
	{
		$sql = "UPDATE park_map SET status = '0' WHERE id = :id";
		if (self::$db->query($sql, array('id' => $id))) {
            //TODO: Fix this when working on fares
			self::$db->query("DELETE FROM fares WHERE route_id = :route_id", array('route_id' => $id));
			return true;
		}
	}
}

?>
