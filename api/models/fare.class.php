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
                    'route_id' => $form['route_id'],
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

		if (count($new_vehicle_types) > 0) {
            $sql = "INSERT INTO " . self::$db_tbl . "
				(vehicle_type_id, fare, park_map_id, route_id, travel_id) VALUE (:vehicle_type_id, :fare, :park_map_id, :route_id, :travel_id)";

            self::$db->prepare($sql);

            for ($i = 0; $i < count($new_vehicle_types['fare']); $i++) {
                $param = array(
                    'fare' => $new_vehicle_types['fare'][$i],
                    'vehicle_type_id' => $new_vehicle_types['vehicle_type_id'][$i],
                    'park_map_id' => $form['park_map_id'],
                    'route_id' => $form['route_id'],
                    'travel_id' => $form['travel_id']
                );
                self::$db->execute($param);
            }
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


    /**
     * Supply park_map id and get all fares for that park_map - park_map is connection between parks
     * optional: travel_id, will ensure that you get fares for only the give travel
     *
     * @param $park_map_id
     * @param null $travel_id
     * @return mixed
     */
    public function getFareByParkMapId($park_map_id, $travel_id = null)
	{
		$where = "";
		if ($travel_id == null) {
			$param = array('park_map_id' => $park_map_id);
		} else {
			$param = array('park_map_id' => $park_map_id, 'travel_id' => $travel_id);
			$where = "AND f.travel_id = :travel_id";
		}
		$sql = "SELECT f.id, tvt.id, f.vehicle_type_id, fare, vehicle_name FROM " . self::$db_tbl . " f
				JOIN travel_vehicle_types tvt ON f.vehicle_type_id = tvt.id
				WHERE park_map_id = :park_map_id $where
				ORDER BY vehicle_name";

		if (self::$db->query($sql, $param)) {
			return self::$db->fetchAll('obj');
		}
	}

    /**
     * Supply route id and get all fares for that route - route is connection between states
     * optional: travel_id, will ensure that you get fares for only the give travel
     *
     * @param $routeId
     * @param null $travel_id
     * @return mixed
     */
    public function getFareByRouteId($routeId, $travel_id = null)
    {
        $where = "";
        if ($travel_id == null) {
            $param = array('route_id' => $routeId);
        } else {
            $param = array('route_id' => $routeId, 'travel_id' => $travel_id);
            $where = "AND f.travel_id = :travel_id";
        }
        $sql = "SELECT f.id, tvt.id, f.vehicle_type_id, fare, vehicle_name FROM " . self::$db_tbl . " f
				JOIN travel_vehicle_types tvt ON f.vehicle_type_id = tvt.id
				WHERE route_id = :route_id $where
				ORDER BY vehicle_name";

        if (self::$db->query($sql, $param)) {
            return self::$db->fetchAll('obj');
        }
    }

    /**
     * Returns fares given origin and destination state ids
     *
     * @param $origin
     * @param $destination
     * @return mixed
     */
    public function getFareByStates($origin, $destination)
    {
        $sql = "SELECT fares.*, pm.origin, pm.destination, d.park AS destination_name, o.park AS origin_name, d_s.state_name AS destination_state, o_s.state_name AS origin_state
                FROM fares
                INNER JOIN park_map AS pm ON fares.park_map_id = pm.id
                INNER JOIN travel_park_map ON travel_park_map.park_map_id = pm.id
                INNER JOIN parks AS d ON pm.destination = d.id
                INNER JOIN parks AS o ON pm.origin = o.id
                INNER JOIN states AS o_s ON o.state_id = o_s.id
                INNER JOIN states AS d_s ON d.state_id = d_s.id
                WHERE o_s.id = :origin_state AND d_s.id = :destination_state";

        if (self::$db->query($sql, array('origin_state' => $origin, 'destination_state' => $destination))) {
            return self::$db->fetch('obj');
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
