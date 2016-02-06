<?php

require_once "model.class.php";

class Trip extends Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function addTrip($travel_park_map_id, $departure, $travel_id, $state_id, $route_id, $vehicle_type, $amenities, $departure_time, $fare)
    {
        if (is_numeric($this->verifyTrip($travel_park_map_id, $vehicle_type, $departure))) {
            return true;
        }

        $sql = "INSERT INTO trips (travel_park_map_id, travel_id, state_id, departure, vehicle_type, route_id, amenities, departure_time, fare)
            VALUES (:travel_park_map_id, :travel_id, :state_id, :departure, :vehicle_type, :route_id, :amenities, :departure_time, :fare)";

        $param = array(
            "travel_park_map_id" => $travel_park_map_id,
            "travel_id" => $travel_id,
            'state_id' => $state_id,
            "departure" => $departure,
            "route_id" => $route_id,
            'vehicle_type_id' => $vehicle_type,
            "amenities" => $amenities,
            "departure_time" => $departure_time,
            "fare" => $fare,
        );
        if (self::$db->query($sql, $param)) {
            return self::$db->getLastInsertId();
        }
    }

    public function updateTrip($trip_id, $amenities, $fare)
    {
        $sql = "UPDATE trips SET amenities = :amenities, fare = :fare WHERE id = :id";
        $result = self::$db->query($sql, array('amenities' => $amenities, 'fare' => $fare, 'id' => $trip_id));
        if ($result !== false) {
            return true;
        }
        return false;
    }

    public function getByState($state_id)
    {
        $sql = "SELECT trips.*, po.park AS origin_name, pd.park AS destination_name
                FROM trips 
                JOIN park_map AS pm ON pm.id = trips.travel_park_map_id
                JOIN parks AS po ON po.id = pm.origin
                JOIN parks AS pd ON pd.id = pm.destination
                WHERE trips.state_id = :state_id";
        self::$db->query($sql, array('state_id' => $state_id));
        return self::$db->fetchAll('obj');
    }

    public function getByStateTravel($state_id, $travel_id)
    {
        $sql = "SELECT trips.*, po.park AS origin_name, pd.park AS destination_name
                FROM trips 
                JOIN park_map AS pm ON pm.id = trips.travel_park_map_id
                JOIN parks AS po ON po.id = pm.origin
                JOIN parks AS pd ON pd.id = pm.destination
                WHERE trips.state_id = :state_id AND travel_id = :travel_id";
        self::$db->query($sql, array('state_id' => $state_id, 'travel_id' => $travel_id));
        return self::$db->fetchAll('obj');
    }

    public function getByPark($park_id)
    {
        $sql = "";
        self::$db->query($sql, array('park_id' => $park_id));
        return self::$db->fetchAll('obj');
    }

    private function verifyTrip($travel_park_map_id, $vehicle_type, $departure)
    {
        $sql = "SELECT id FROM trips WHERE travel_park_map_id = :travel_park_map_id AND vehicle_type = :vehicle_type AND departure = :departure";
        $param = array(
            'travel_park_map_id' => $travel_park_map_id,
            'vehicle_type' => $vehicle_type,
            'departure' => $departure
        );
        self::$db->query($sql, $param);
        if ($id = self::$db->fetch('obj')) {
            return $id->id;
        }
    }
}
