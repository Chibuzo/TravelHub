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


	function getRouteId($route)
	{
		$sql = "SELECT id FROM routes WHERE route = :route";
		$param = array('route' => $route);
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


	public function getDestination($origin)
	{
		return parent::getManyById('routes', 'origin', $origin, 'destination');
	}


	//function getRouteMap($route_id)
	//{
	//	$sql = "SELECT route FROM routes WHERE id = :id";
	//	$param = array('id' => $route_id);
	//	self::$db->query($sql, $param);
	//	if ($result = self::$db->fetch()) {
	//		return $result;
	//	} else {
	//		return false;
	//	}
	//}


	public function editRoute($origin, $destination, $id)
	{
		$route_map = $origin . ' - ' . $destination;
		$sql = "UPDATE routes SET
					origin = :origin,
					destination = :destination,
					route = :route
				WHERE id = :id";

		$param = array(
			'origin' => $origin,
			'destination' => $destination,
			'route' => $route_map,
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
