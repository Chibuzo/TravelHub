<?php
include_once 'apicaller.php';

$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'http://localhost/schooldays/sd_api/');

try {
	$todo_items = $apicaller->sendRequest(array(
		'controller' => 'User',
		'action' => 'authenticate',
		'email' => 'uzo.system@gmail.com',
		'password' => 'untold'
		
	));
	
	var_dump($todo_items);
} catch (Exception $e) {
	echo $e->getMessage();
}

?>