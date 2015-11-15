<?php
require_once "model.class.php";

class Fare extends Model
{
	private static $db_tbl = "fares";

	public function __construct()
	{
		parent::__construct();
	}


	public function addFare($form)
	{
		$sql = "INSERT INTO " . self::$db_tbl . "
				(travel_id, vehicle_type_id, fare, park_map_id) VALUE (:travel_id, :vehicle_type_id, :fare, :park_map_id)";

		self::$db->prepare($sql);

		foreach ($form AS $key => $val) {
			if (is_numeric($key)) {
				$param = array(
					'travel_id' => $form['travel_id'],
					'vehicle_type_id' => $key,
					'fare' => $val,
					'park_map_id' => $form['park_map_id']
				);
				self::$db->execute($param);
			}
		}
		return true;
	}


	//public function addSingleFare($travel_id, $route_id, $vehicle_type_id, $fare)
	//{
	//	$sql = "INSERT INTO " . self::$db_tbl . "
	//			(travel_id, bus_type_id, fare, route_id) VALUE (:travel_id, :bus_type_id, :fare, :route_id)";
	//
	//	$param = array(
	//		'travel_id' => $form['travel_id'],
	//		'vehicle_type_id' => $vehicle_type_id,
	//		'fare' => $fare,
	//		'route_id' => $route_id
	//	);
	//	if (self::$db->query($sql, $param)) {
	//		return true;
	//	}
	//}


	public function editFare($form)
	{
		$sql = "UPDATE " . self::$db_tbl . " SET
					fare = :fare
				WHERE vehicle_type_id = :vehicle_type_id AND park_map_id = :park_map_id AND travel_id = :travel_id";

		$bus_types = $this->getAllVehicleTypesInUse($form['park_map_id'], $form['travel_id']);

		self::$db->prepare($sql);

		$new_vehicle_types = array();
		foreach ($form AS $key => $val) {
			if (is_numeric($key) && in_array($key, $bus_types)) { // update existing vehicle type
				$param = array(
					'fare' => $val,
					'vehicle_type_id' => $key,
					'park_map_id' => $form['park_map_id'],
                    'travel_id' => $form['travel_id']
				);
				self::$db->execute($param);
			} else { // add fare for new vehicle type
				if (is_numeric($key)) {
					$new_vehicle_types['vehicle_type_id'][] = $key;
					$new_vehicle_types['fare'][] = $val;
				}
			}
		}

		$sql = "INSERT INTO " . self::$db_tbl . "
				(vehicle_type_id, fare, park_map_id, travel_id) VALUE (:vehicle_type_id, :fare, :park_map_id, :travel_id)";

		self::$db->prepare($sql);

		for ($i = 0; $i < count($new_vehicle_types['fare']); $i++) {
			$param = array(
				'fare' => $new_vehicle_types['fare'][$i],
				'vehicle_type_id' => $new_vehicle_types['vehicle_type_id'][$i],
				'park_map_id' => $form['park_map_id'],
				'travel_id' => $form['travel_id']
			);
			self::$db->execute($param);
		}
	}


	//private function checkRouteFares($route_id)
	//{
	//	$sql = "SELECT COUNT(*) num FROM " . self::$db_tbl . " WHERE route_id = :route_id";
	//	self::$db->query($sql, $param);
	//	if ($result = self::$db->fetch('obj')) {
	//		return $result->num;
	//	} else {
	//		return 0;
	//	}
	//}


	private function getAllVehicleTypesInUse($park_map_id, $travel_id)
	{
		$sql = "SELECT vehicle_type_id FROM " . self::$db_tbl . " WHERE park_map_id = :park_map_id AND travel_id = :travel_id";
		self::$db->query($sql, array('park_map_id' => $park_map_id, 'travel_id' => $travel_id));
        $vehicle_types = array();
		foreach (self::$db->stmt AS $row) {
			$vehicle_types[] = $row['vehicle_type_id'];
		}
		return $vehicle_types;
	}


	public function getAllFares()
	{
		return parent::getAll(self::$db_tbl);
	}


	public function getAllFaresByTravelId($travel_id)
	{
		return parent::getManyById(self::$db_tbl, 'travel_id', $travel_id);
	}


	public function getFareById($id)
	{
		return parent::getOneById(self::$db_tbl, $id);
	}


	public function getFareByRouteId($park_map_id, $travel_id = null)
	{
		$where = "";
		if ($travel_id == null) {
			$param = array('park_map_id' => $park_map_id);
		} else {
			$param = array('park_map_id' => $park_map_id, 'travel_id' => $travel_id);
			$where = "AND f.travel_id = :travel_id";
		}
		$sql = "SELECT f.id, tvt.id vehicle_type_id, fare, vehicle_name FROM " . self::$db_tbl . " f
				JOIN travel_vehicle_types tvt ON f.vehicle_type_id = tvt.id
				WHERE park_map_id = :park_map_id $where
				ORDER BY vehicle_name";

		//$param = array('route_id' => $route_id, 'travel_id' => $travel_id);

		if (self::$db->query($sql, $param)) {
			return self::$db->fetchAll('obj');
		}
	}


	public function getFareByBusType($vehicle_type_id, $park_map_id, $travel_id)
	{
		$sql = "SELECT fare, id FROM " . self::$db_tbl . "
				WHERE vehicle_type_id = :vehicle_type_id AND park_map_id = :park_map_id AND travel_id = :travel_id";

		$param = array(
			'vehicle_type_id' => $vehicle_type_id,
			'route_id' => $park_map_id,
			'travel_id' => $travel_id
		);

		self::$db->query($sql, $param);
		if ($result = self::$db->fetch('obj')) {
			return $result;
		} else {
			return false;
		}
	}


	private function deleteAllRouteFares($park_map_id, $travel_id)
	{
		$param = array('route_id' => $park_map_id, 'travel_id' => $travel_id);
		self::$db->query("DELETE FROM " . self::$db_tbl . " WHERE park_map_id = :park_map_id AND travel_id = :travel_id", $param);
	}
}
?>
