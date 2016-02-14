<?php

require_once "model.class.php";

class Trip extends Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function addTrip($park_map_id, $departure, $travel_id, $state_id, $route_id, $vehicle_type_id, $amenities, $departure_time, $fare)
    {
        if (is_numeric($this->verifyTrip($park_map_id, $vehicle_type_id, $departure))) {
            return true;
        }

        $sql = "INSERT INTO trips (park_map_id, travel_id, state_id, departure, vehicle_type_id, route_id, amenities, departure_time, fare)
            VALUES (:park_map_id, :travel_id, :state_id, :departure, :vehicle_type_id, :route_id, :amenities, :departure_time, :fare)";

        $param = array(
            "park_map_id" => $park_map_id,
            "travel_id" => $travel_id,
            'state_id' => $state_id,
            "departure" => $departure,
            "route_id" => $route_id,
            'vehicle_type_id' => $vehicle_type_id,
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
                JOIN park_map AS pm ON pm.id = trips.park_map_id
                JOIN parks AS po ON po.id = pm.origin
                JOIN parks AS pd ON pd.id = pm.destination
                WHERE trips.state_id = :state_id";
        self::$db->query($sql, array('state_id' => $state_id));
        return self::$db->fetchAll('obj');
    }

    public function getByStateTravel($state_id, $travel_id)
    {
        $sql = "SELECT trips.*, po.park AS origin_name, pd.park AS destination_name, vt.name AS vehicle_name
                FROM trips 
                JOIN park_map AS pm ON pm.id = trips.park_map_id
                JOIN parks AS po ON po.id = pm.origin
                JOIN parks AS pd ON pd.id = pm.destination
                JOIN vehicle_types vt ON vt.id = trips.vehicle_type_id
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

    private function verifyTrip($park_map_id, $vehicle_type_id, $departure)
    {
        $sql = "SELECT id FROM trips WHERE park_map_id = :park_map_id AND vehicle_type_id = :vehicle_type_id AND departure = :departure";
        $param = array(
            'park_map_id' => $park_map_id,
            'vehicle_type_id' => $vehicle_type_id,
            'departure' => $departure
        );
        self::$db->query($sql, $param);
        if ($id = self::$db->fetch('obj')) {
            return $id->id;
        }
    }
}
