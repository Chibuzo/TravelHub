<?php

class Route extends Oya {
	private $params;
	private $route_obj;
	
	function __construct($params=null)
	{
		parent::__construct();
		$this->params = $params;
		$this->route_obj = new RouteModel();
	}
	
	
	function getRoutes()
	{
		return $this->route_obj->getRoutes();
	}
	
	
	function getRouteId()
	{
		$route = "{$this->params['origin']} - {$this->params['destination']}";
		return $this->route_obj->getRouteId($route);
	}
	
	
	function getRouteMap()
	{
		return $this->route_obj->getRouteMap($this->params['route_id']);
	}
}

?>