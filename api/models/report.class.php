<?php
require_once "model.class.php";

class Report extends Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function getDailyReport($date, $travel_id = null, $state_id = null, $park_id = null)
	{
		$filter = '';
		$param = array('travel_date' => date('Y-m-d', strtotime($date)));
		if (is_numeric($travel_id)) {
			$filter .= " AND bv.travel_id = :travel_id";
			$param['travel_id'] = $travel_id;
		}
		if (is_numeric($state_id)) {
			$filter .= " AND os.id = :state_id";
			$param['state_id'] = $state_id;
		}
		if (is_numeric($park_id)) {
			$filter .= " AND pm.origin = :park_id";
			$param['park_id'] = $park_id;
		}
		$sql = "SELECT t.abbr, t.id travel_id, os.state_name origin_state, os.id origin_id, ds.state_name dest_state, ds.id dest_id, op.park origin_park, op.id park_id, dp.park dest_park, bv.departure_order, vehicle_name, booked_seats, bv.fare, (scouters_charge + drivers_feeding + fuel + expenses) AS expenses FROM boarding_vehicle bv
				JOIN travel_vehicle_types tvt ON bv.vehicle_type_id = tvt.vehicle_type_id AND bv.travel_id = tvt.travel_id
				LEFT JOIN manifest_account ma ON bv.id = boarding_vehicle_id
				JOIN travels t ON bv.travel_id = t.id
				JOIN park_map pm ON bv.park_map_id = pm.id
				JOIN parks op ON pm.origin = op.id
				JOIN parks dp ON pm.destination = dp.id
				JOIN states os ON op.state_id = os.id
				JOIN states ds ON dp.state_id = ds.id
				WHERE travel_date = :travel_date" . $filter;

		self::$db->query($sql, $param);
		if ($reports = self::$db->fetchAll()) {
			return $reports;
		} else {
			return array();
		}
	}
}
?>
