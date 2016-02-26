<?php
require_once "model.class.php";
require_once "trip.class.php";

class VehicleModel extends Model {
	private $trip = null;

	function __construct()
	{
		parent::__construct();

		$this->trip = new Trip();
	}


	function findVehicles($route_id)
	{
		return $this->trip->getTripsByRoute($route_id);
	}


	public function addVehicleType($vehicle_name, $num_of_seat)
	{
		$sql = "INSERT INTO vehicle_types (name, num_of_seats) VALUES (:name, :num_of_seat)";
		$param = array('name' => $vehicle_name, 'num_of_seat' => $num_of_seat);
		if (self::$db->query($sql, $param)) {
			return true;
		}
	}


	public function updateVehicleType($vehicle_name, $num_of_seat, $id)
	{
		$sql = "UPDATE vehicle_types SET
					name = :name,
					num_of_seats = :num_of_seat
				WHERE id = :id";

		$param = array(
			'name' => $vehicle_name,
			'num_of_seat' => $num_of_seat,
			'id' => $id
		);
		if (self::$db->query($sql, $param)) {
			return true;
		}
	}


	public function findBoardingVehicle($travel_id, $vehicle_type_id, $route_id, $departure_order, $travel_date)
	{
		$query = "";
		if (is_numeric($departure_order)) {
			$query = "AND departure = '$departure_order'";
		}
		$sql = "SELECT tr.id trip_id, tr.fare FROM trips tr
				WHERE travel_id = :travel_id AND vehicle_type_id = :vehicle_type AND route_id = :route_id $query
				ORDER BY departure DESC LIMIT 0, 1";

		$param = array(
			'travel_id' => $travel_id,
			'vehicle_type' => $vehicle_type_id,
			'route_id' => $route_id
		);
		self::$db->query($sql, $param);
		if ($vehicle = self::$db->fetch('obj')) {
			return $vehicle;
		} else {
			return false; // no boarding vehicle
		}
	}


	public function fixBoardingVehicles($vehicle_type_id, $route_id, $travel_date)
	{
		$vehicles = $this->trip->getDailyTrips($vehicle_type_id, $route_id);

		//$sql = "SELECT id FROM boarding_vehicles WHERE travel_date"
		$sql = "INSERT INTO boarding_vehicle (trip_id, fare, departure_order, travel_date) VALUES (:trip_id, :fare, :departure_order, :travel_date)";
		self::$db->prepare($sql);
		foreach ($vehicles AS $vehicle) {
			$param = array(
				'trip_id' => $vehicle->trip_id,
				'fare' => $vehicle->fare,
				'departure_order' => $vehicle->departure,
				'travel_date' => $travel_date
			);
			self::$db->execute($param);
		}
	}


	public function getAllVehicleTypes()
	{
		$sql = "SELECT * FROM vehicle_types WHERE removed = '0' ORDER BY name";
		self::$db->query($sql);
		return self::$db->fetchAll('obj');
	}


	function charterVehicle()
	{
		$sql = "INSERT INTO vehicle_charter
				(customer_name, customer_phone, next_of_kin, email, departure_location, destination, date_of_travel, date_chartered)
				VALUES
				(:customer_name, :customer_phone, :next_of_kin, :email, :departure_location, :destination, :travel_date, NOW())";

		$param = array(
			'customer_name' => $_POST['customer_name'],
			'customer_phone' => $_POST['customer_phone'],
			'next_of_kin' => $_POST['email'],
			'email' => $_POST['email'],
			'departure_location' => $_POST['departure_location'],
			'destination' => $_POST['destination'],
			'travel_date' => $_POST['travel_date']
		);

		if (self::$db->query($sql, $param))
			return true;
	}


	public function removeVehicle($id)
	{
		$sql = "UPDATE vehicle_types SET removed = '1' WHERE id = :id";
		if (self::$db->query($sql, array('id' => $id))) {

			// remove from fares
			$sql = "DELETE FROM fares WHERE vehicle_type_id = :id";
			self::$db->query($sql, array('id' => $id));
			return true;
		}
	}
}

?>
