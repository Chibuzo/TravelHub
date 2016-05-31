<?php

class Bootstrap {
	
	public function __construct() {	}
	
	
	function route($params)
	{
		# Process action name with underscore to camel back
		if (strstr($params['action'], '_')) {
			$action = '';
			$words = explode('_', $params['action']);
			foreach ($words AS $word) {
				$action .= ucfirst($word);
			}
			$action = lcfirst($action);
		} else {
			$action = $params['action'];
		}

		$_controller = $params['controller'];

		if (class_exists($_controller)) {
			unset($params['controller'], $params['action']);
			$controller = new $_controller($params);

			if (method_exists($controller, $action) === false) {
				throw new Exception ('Action invalid');
			}

			$result['data'] = $controller->$action();
			$result['success'] = true;
			return $result;
		} else {
			throw new Exception ('Controller not found');
		}
		
	}
}


if (function_exists('lcfirst') === false) {
    function lcfirst($str) {
        $str[0] = strtolower($str[0]);
        return $str;
    }
}
?>