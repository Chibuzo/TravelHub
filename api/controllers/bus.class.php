<?php

class Bus extends Oya {
	private $params;
	private $bus;
	
	function __construct($params=null)
	{
		parent::__construct();
		$this->params = $params;
		$this->bus = new BusModel();
		
		//var_dump($this->params);
	}
	
	
	function findBuses()
	{
		return $this->bus->findBuses($this->params);
	}
}

?>