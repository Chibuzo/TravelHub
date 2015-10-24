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
		}
		
		try {
			if (class_exists($params['controller']))
			{
				$controller = new $params['controller']($params);
				
				if (method_exists($controller, $action) === false) {
					throw new Exception ('Action invalid');
				}
				
				$result['data'] = $controller->$action();
				$result['success'] = true;
				return $result;
			} else {
				throw new Exception ('Controller not found');
			}
		} catch (Exception $e) {
			echo $e->getMessage();
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