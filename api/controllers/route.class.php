<?php

class Route extends TravelHub {
	private $params;
	private $route_obj;
	
	function __construct($params=null)
	{
		parent::__construct();
		$this->params = $params;
		$this->model = new RouteModel();
	}
	
	
	function getRoutes()
	{
		return $this->model->getRoutes();
	}
	
	
	function getRouteId()
	{
		$route = "{$this->params['origin']} - {$this->params['destination']}";
		return $this->route_obj->getRouteId($route);
	}
}
?>