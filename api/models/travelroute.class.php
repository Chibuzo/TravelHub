<?php
require_once "routemodel.class.php";

class TravelRoute extends RouteModel {
	public $id, $travel_id, $route_id, $status;
	protected static $tbl = "travel_routes";

	function __construct()
	{
		parent::__construct();
	}


	public function addRoute($origin, $destination, $travel_id)
	{
		$route_id = parent::addRoute($origin, $destination);

		// check if the route has been added already
		if (is_numeric($this->verifyRoute($route_id, $travel_id))) {
			return true;
		}

		$sql = "INSERT INTO " . self::$tbl . " (travel_id, route_id) VALUES (:travel_id, :route_id)";
		$param = array(
			'travel_id' =>$travel_id,
			'route_id' => $route_id
		);
		if ($this->db->query($sql, $param)) {
			return self::$db->getLastInsertId();
		}
	}

    public function getTravelRoutes($travel_id)
    {
        $sql = "SELECT routes.* FROM routes INNER JOIN travel_routes ON travel_routes.route_id = routes.id WHERE travel_routes.travel_id = :travel_id AND travel_routes.removed = '0'";
        self::$db->query($sql, array('travel_id' => $travel_id));
        return self::$db->fetchAll('obj');
    }


	public function verifyRoute($route_id, $travel_id)
	{
		$sql = "SELECT id FROM " . self::$tbl . " WHERE route_id = :route_id AND travel_id = :travel_id";
		$param = array(
			'travel_id' => $travel_id,
			'route_id' => $route_id
		);
		$this->db->query($sql, $param);
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
