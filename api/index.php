<?php
require_once "../config/paths.php";
require_once "autoloader.class.php";

$autoloader = new ClassAutoloader();

// We'll use the appID to get the app_key, haha
$applications = array(
	'APP001' => '28e336ac6c9423d946ba02d19c6a2632', //randomly generated app key
);

$enc_request = $_REQUEST['enc_request'];
$app_id = $_REQUEST['app_id'];

try {
	//check first if the app id exists in the list of applications
	if( !isset($applications[$app_id]) ) {
		throw new Exception('Application does not exist!');
	}

	//decrypt the request
	$params = json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $applications[$app_id], base64_decode($enc_request), MCRYPT_MODE_ECB)));

	//check if the request is valid by checking if it's an array and looking for the controller and action
	if (!isset($params->controller) || !isset($params->action)) {
		throw new Exception('Request is not valid');
	}

	$params = (array) $params;

	$bootstrap = new Bootstrap();
	$result = $bootstrap->route($params);
	echo json_encode($result);
} catch (Exception $e) {
	echo $e->getMessage();
}
?>
