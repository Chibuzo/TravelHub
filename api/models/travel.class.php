<?php
require_once "model.class.php";

class Travel extends Model {

	private $tbl = 'travels';
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function getTravel($travel_id)
    {
        $sql = "SELECT id, company_name, abbr, offline_charge, online_charge FROM travels WHERE id = :id";
        self::$db->query($sql, array('id' => $travel_id));
        return self::$db->fetch('obj');
    }

    function getTravels()
    {
        try {
            $sql = "SELECT id, company_name, abbr, offline_charge, online_charge FROM travels WHERE deleted = '0' ORDER BY date_created";
            self::$db->query($sql);
            return self::$db->fetchAll('obj');
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getTravelByUser($user_id)
    {
        $sql = "SELECT travels.id, travels.company_name, travels.offline_charge, travels.online_charge FROM travel_admins JOIN travels ON travel_admins.travel_id = travels.id WHERE travel_admins.id = :user_id";
        self::$db->query($sql, array('user_id' => $user_id));
        return self::$db->fetch('obj');
    }

    function getTravelStates($travel_id)
    {
        $sql = "SELECT travel_state.id, travel_state.travel_id AS travel_id, states.state_name, states.id AS state_id, travel_admins.fullname, travel_admins.username, travel_admins.id AS user_id
                FROM travel_state INNER JOIN states ON travel_state.state_id = states.id
                INNER JOIN travel_admins ON travel_state.user_id = travel_admins.id
                WHERE travel_state.travel_id = :travel_id";

       // try {
            self::$db->query($sql, array('travel_id' => $travel_id));
            return self::$db->fetchAll('obj');
       /* } catch (\Exception $e) {
            echo $e->getMessage();
        }*/

    }

    function getTravelStateByUser($user_id)
    {
        $sql = "SELECT travel_state.id, travel_state.travel_id AS travel_id, states.state_name, states.id as state_id, travel_admins.fullname, travel_admins.username, travel_admins.id AS user_id FROM travel_state INNER JOIN states ON travel_state.state_id = states.id INNER JOIN travel_admins ON travel_state.user_id = travel_admins.id WHERE travel_state.user_id = :user_id";
        self::$db->query($sql, array('user_id' => $user_id));
        return self::$db->fetch('obj');
    }

    function getTravelParkByUser($user_id)
    {
        $sql = "SELECT travel_park.id, travel_park.travel_id AS travel_id, parks.park AS park, parks.id AS park_id, states.state_name, states.id as state_id, travel_admins.fullname, travel_admins.username, travel_admins.id AS user_id
            FROM travel_park
            INNER JOIN parks ON parks.id = travel_park.park_id
            INNER JOIN states ON parks.state_id = states.id
            INNER JOIN travel_admins ON travel_park.user_id = travel_admins.id
            WHERE travel_park.user_id = :user_id";
        self::$db->query($sql, array('user_id' => $user_id));
        return self::$db->fetch('obj');
    }

    function getTravelParks($travel_id)
    {
        $sql = "SELECT travel_park.id, travel_park.travel_id AS travel_id, parks.park, states.state_name AS state_name, states.id AS state_id, travel_admins.fullname, travel_admins.username, travel_admins.id AS user_id
                FROM travel_park
                INNER JOIN parks ON travel_park.park_id = parks.id
                INNER JOIN travel_admins ON travel_park.user_id = travel_admins.id
                INNER JOIN states ON states.id = parks.state_id
                WHERE travel_park.travel_id = :travel_id";
        self::$db->query($sql, array('travel_id' => $travel_id));
        return self::$db->fetchAll('obj');
    }

    function saveTravel(array $params)
    {
        if (!isset($params['id'])) {
            return $this->addTravel($params);
        } else {
            return $this->updateTravel($params);
        }
    }

    private function addTravel($params)
    {
        try {
            $sql = "INSERT INTO {$this->tbl} (company_name, abbr, offline_charge, online_charge) VALUES (:company_name, :abbr, :offline_charge, :online_charge)";

            $result = self::$db->query($sql, $params);
            if ($result !== false) {
                $params['id'] = self::$db->getLastInsertId();
                return $params;
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }

    private function updateTravel($params)
    {
        $sql = "UPDATE {$this->tbl} SET company_name = :company_name, abbr = :abbr, offline_charge = :offline_charge, online_charge = :online_charge WHERE id = :id";

        $result = self::$db->query($sql, $params);
        if ($result !== false) {
            return true;
        }
        return false;
    }


    public function getTravelDepot($trip_id)
    {
        $sql = "SELECT abbr, park FROM travels t
                JOIN trips tr ON t.id = tr.travel_id
                JOIN park_map pm ON tr.park_map_id = pm.id
                JOIN parks p ON pm.origin = p.id
                WHERE tr.id = :trip_id";

        self::$db->query($sql, array('trip_id' => $trip_id));
        return self::$db->fetch('obj');
    }
	
	function getServiceCharge($travel_id)
	{
		$sql = "SELECT offline_charge, online_charge FROM {$this->tbl} WHERE id = :travel_id";
		self::$db->query($sql, array('travel_id' => $travel_id));
		return self::$db->fetch('obj');
	}
}