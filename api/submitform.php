#<?php
#include_once '../apicaller.php';
#define ("BASE_URL", "http://localhost/oya/");
#$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', BASE_URL . 'api/');
#
#// $url = $_REQUEST['url']
#$url = "http://localhost/color/pick_bus.php";
#if ($_POST['origin'] == 'route')
#{
#	submitRouteForm($apicaller);
#}
#
#
#function submitRouteForm($apicaller, $url) {
#	try {
#		$route_id = $apicaller->sendRequest(array(
#			'controller' => 'Route',
#			'action' => 'get_route_id',
#			'origin' => $_POST['origin'],
#			'destination' => $_POST['destination']
#		));
#	} catch (Exception $e) {
#		echo $e->getMessage();
#	}
#	
#	header ("Location: {$url}?route_id=" . $route_id->id);
#}
#?>