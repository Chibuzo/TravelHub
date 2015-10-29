<?php
require_once "../api/models/model.class.php";

class Travel extends Model {

	private $tbl = 'travels';
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function getTravel($travel_id)
    {

    }

    function getTravels()
    {

    }

    function saveTravel(array $params)
    {
        if (isset($params['id'])) {
            return $this->addTravel($params);
        } else {
            return $this->updateTravel($params);
        }
    }

    private function addTravel($params)
    {
        $sql = "INSERT INTO {$this->tbl} (company_name, offline_charge, online_charge) VALUES (:company_name, :offline_charge, :online_charge)";
        $result = self::$db->query($sql, $params);
        if ($result !== false) {
            $params['id'] = self::$db->getLastInsertId();
            return $params;
        }
        return false;
    }

    private function updateTravel($params)
    {
        $sql = "UPDATE {$this->tbl} SET company_name = :company_name, offline_charge = :offline_charge, online = :offline_charge WHERE id = :id";
        $result = self::$db->query($sql, $params);
        if ($result !== false) {
            return true;
        }
        return false;
    }
	
	function getServiceCharge($travel_id)
	{
		$sql = "SELECT offline_charge, online_charge FROM {$this->tbl} WHERE id = :travel_id";
		self::$db->query($sql, array('travel_id' => $travel_id));
		return self::$db->fetch('obj');
	}
}