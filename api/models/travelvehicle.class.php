<?php
require_once "model.class.php";

class TravelVehicle extends Model
{
    private static $tbl = "travel_vehicle_types";

    public function __construct()
    {
        parent::__construct();
    }


    public function addVehicleType($travel_id, $vehicle_name, $vehicle_type_id, $num_of_seats, $push_opt = 'Push')
    {
        // check if vehicle has been added already
        $sql = "SELECT id FROM " . self::$tbl . " WHERE travel_id = :travel_id AND vehicle_type_id = :vehicle_type_id";
        $param = array(
            'travel_id' => $travel_id,
            'vehicle_type_id' => $vehicle_type_id
        );
        self::$db->query($sql, $param);
        if ($d = self::$db->fetch()) {
            return true;
        }

        $sql = "INSERT INTO " . self::$tbl . "
                (travel_id, vehicle_name, vehicle_type_id)
            VALUES
                (:travel_id, :vehicle_name, :vehicle_type_id)";

       $param['vehicle_name'] = $vehicle_name;

        if (self::$db->query($sql, $param)) {
            $param['num_of_seats'] = $num_of_seats;
            $param['category'] = $_SESSION['abbr'];
            if ($push_opt == 'Push') {
                try {
                    self::pushData($param, 'add-vehicle-type');
                } catch (Exception $e) {
                    // log exception
                }
            }
            return true;
        }
    }


    public function updateVehicleType($vehicle_name, $vehicle_type_id, $amenities, $id)
    {
        $sql = "UPDATE " . self::$tbl . " SET
                    vehicle_name = :vehicle_name,
                    vehicle_type_id = :vehicle_type_id,
                    amenities = :amenities
                WHERE id = :id";

        $param = array(
            'vehicle_name' => $vehicle_name,
            'vehicle_type_id' => $vehicle_type_id,
            'amenities' => $amenities,
            'id' => $id
        );

        if (self::$db->query($sql, $param)) {
            return true;
        }
    }


    public function getAllVehicleTypes($travel_id)
    {
        $sql = "SELECT travel_vehicle_types.*, vehicle_types.num_of_seats, vehicle_types.name AS type_name, vehicle_types.id AS vehicle_type_id
                FROM " . self::$tbl . "
                INNER JOIN vehicle_types ON vehicle_types.id = travel_vehicle_types.vehicle_type_id
                WHERE travel_id = :travel_id AND status = '0' ORDER BY vehicle_name";
        self::$db->query($sql, array('travel_id' => $travel_id));
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


    public function disableVehicle($id)
    {
        $sql = "UPDATE " . self::$tbl . " SET status = '0' WHERE id = :id";
        if (self::$db->query($sql, array('id' => $id))) {

            // remove from fares we'll watch this murdafucka
            //$sql = "DELETE FROM fares WHERE vehicle_type_id = :id";
            //$this->db->query($sql, array('id' => $id));
            return true;
        }
    }
}

?>
