<?php
require_once "travel.class.php";

class VehicleCharter extends Travel
{
	private static $db_tbl = "vehicle_charter";
	
	public function __construct()
	{
		parent::__construct();
	}


	public function addCharter($name, $phone, $email, $travel_date, $origin, $destination, $vehicle_type, $num_of_vehicles)
	{
		$sql = "INSERT INTO " . self::$db_tbl . "
				(name, phone, email, origin, destination, travel_date, vehicle_type, num_of_vehicles)
					VALUES
				(:name, :phone, :email, :origin, :destination, :travel_date, :vehicle_type, :num_of_vehicles)";

		$param = array(
			'name' => $name,
			'phone' => $phone,
			'email' => $email,
			'origin' => $origin,
			'destination' => $destination,
			'travel_date' => date('Y-m-d', strtotime($travel_date)),
			'vehicle_type' => $vehicle_type,
			'num_of_vehicles' => $num_of_vehicles
		);

		if (self::$db->query($sql, $param)) {
			return true;
		}
	}


	public function getPendingCharters()
	{
		$sql = "SELECT vc.* FROM " . self::$db_tbl . " vc
				WHERE status = 'Pending' ORDER BY travel_date DESC";
        self::$db->query($sql);
		return self::$db->fetchAll('obj');
	}
	
	
	public function cancel($id)
	{
		return $this->changeStatus($id, 'Cancelled');
	}
	
	
	public function confirm($id)
	{
		return $this->changeStatus($id, 'Confirmed');
	}


	private function changeStatus($id, $status) {
		self::$db->query("UPDATE " . self::$db_tbl . " SET status = '$status' WHERE id = :id", array('id' => $id));
		if (self::$db->stmt) {
			return true;
		}
	}
}
