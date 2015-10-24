<?php
require_once "travel.class.php";

class BusCharter extends Travel
{
	private static $db_tbl = "bus_charter";
	public function __construct()
	{
		parent::__construct();
	}


	public function addBusCharter($name, $phone, $travel_date, $pickup_location, $destination, $vehicle_type, $num_of_vehicles)
	{
		$sql = "INSERT INTO " . self::$db_tbl . "
				(name, phone, departure_location, destination, travel_date, bus_type_id, num_of_vehicles)
					VALUES
				(:name, :phone, :pickup, :destination, :travel_date, :bus_type_id, :num_of_vehicles)";

		$param = array(
			'name' => $name,
			'phone' => $phone,
			'pickup' => $pickup_location,
			'destination' => $destination,
			'travel_date' => date('Y-m-d', strtotime($travel_date)),
			'bus_type_id' => $vehicle_type,
			'num_of_vehicles' => $num_of_vehicles
		);

		if (self::$db->query($sql, $param)) {
			return true;
		}
	}


	public function getBusCharter()
	{
		$sql = "SELECT bc.*, bt.name bus_type FROM " . self::$db_tbl . " bc
				JOIN vehicle_types bt ON bc.bus_type_id = bt.id";
        self::$db->query($sql);
		return self::$db->fetchAll('obj');
	}


	//public function
}
