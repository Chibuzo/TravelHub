<?php
require_once "model.class.php";

class RouteModel extends Model {
	protected static $tbl = "routes";

	function __construct() {
		parent::__construct();
	}


	function getRoutes()
	{
		self::$db->query("SELECT name AS route_name FROM states_towns");
		return self::$db->fetchAll();
	}


	function getRouteId($origin, $destination)
	{
		$sql = "SELECT id FROM routes WHERE origin = :origin AND destination = :destination";
		$param = array('origin' => $origin, 'destination' => $destination);
		self::$db->query($sql, $param);
		if ($result = self::$db->fetch('obj')) {
			return $result->id;
		} else {
			return false;
		}
	}


	public function checkRouteExist($origin, $destination)
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


	public function addRoute($origin, $destination)
	{
		$route_id = $this->checkRouteExist($origin, $destination);
		if (is_numeric($route_id)) {
			return $route_id;
		}
		$route_map = $origin . ' - ' . $destination;
		$sql = "INSERT INTO routes (origin, destination, route) VALUES (:origin, :destination, :route)";
		$param = array(
			'origin' => $origin,
			'destination' => $destination,
			'route' => $route_map
		);
		if (self::$db->query($sql, $param)) {
			return self::$db->getLastInsertId();
		}
	}


	public function getAllRoutes()
	{
		return parent::getManyById('routes', 'status', 1, 'route');
	}

    public function getRouteNames()
    {
        $sql = "SELECT r.*, os.state_name AS origin_state, ds.state_name AS destination_state FROM routes r JOIN states os ON os.id = r.origin JOIN states ds ON ds.id = r.destination";
        self::$db->query($sql);
        return self::$db->fetchAll('obj');
    }

	public function getDestination($origin)
	{
		$sql = "SELECT CONCAT(destination, '-', state_name) dest_concat, destination, state_name FROM routes r JOIN states s ON r.destination = s.id WHERE origin = :origin ORDER BY state_name";
		self::$db->query($sql, array('origin' => $origin));
		return self::$db->fetchAll();
	}


	/*
	 * get all origin and destination separately
	**/
	public function getOriginsAndDestinations()
	{
		$routes = array();
		self::$db->query("SELECT DISTINCT origin origin_id, state_name FROM routes r JOIN states s ON r.origin = s.id ORDER BY state_name ");
		$routes['origins'] = self::$db->fetchAll('obj');

		self::$db->query("SELECT DISTINCT destination destination_id, state_name FROM routes r JOIN states s ON r.destination = s.id ORDER BY state_name ");
		$routes['destinations'] = self::$db->fetchAll('obj');
		return $routes;
	}


	/*
	 * for fast and easy route selection on the home page
	 */
	public function mapAllOrigin($origins)
	{
		$route_map = array();
		foreach ($origins AS $origin) {
			$route_map[$origin->origin_id] = $this->getDestination($origin->origin_id);
		}

		// flatten the shitty array result
		array_walk($route_map, function(&$destinations) {
			$temp = array();
			foreach ($destinations AS $key => $val) {
				$temp[] = $val['dest_concat'];
			}
			$destinations = implode(",", $temp);
		});
		return $route_map;
	}


	public function editRoute($origin, $destination, $id)
	{
		$sql = "UPDATE routes SET
					origin = :origin,
					destination = :destination,
					route = CONCAT((SELECT state_name FROM states WHERE id = :origin_2), ' - ', (SELECT state_name FROM states WHERE id = :destination_2))
				WHERE id = :id";

		$param = array(
			'origin' => $origin,
			'origin_2' => $origin,
			'destination' => $destination,
			'destination_2' => $destination,
			'id' => $id
		);
		if (self::$db->query($sql, $param)) {
			return true;
		}
	}


	public function removeRoute($id)
	{
		$sql = "UPDATE routes SET status = '0' WHERE id = :id";
		if (self::$db->query($sql, array('id' => $id))) {
			self::$db->query("DELETE FROM fares WHERE park_map_id = :park_map_id", array('park_map_id' => $id));
			return true;
		}
	}
}

?>
