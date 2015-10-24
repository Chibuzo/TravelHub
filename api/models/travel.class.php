<?php
require_once "../api/models/model.class.php";

class Travel extends Model {
	private $tbl = 'travels';
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function addTravel()
	{
		
	}
	
	
	function getServiceCharge($travel_id)
	{
		$sql = "SELECT offline_charge, online_charge FROM {$this->tbl} WHERE id = :travel_id";
		$this->db->query($sql, array('travel_id' => $travel_id));
		return $this->db->fetch('obj');
	}
}

?>