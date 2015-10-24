<?php

#class ClassAutoloader {
#	public function __construct() {
#		spl_autoload_register(array($this, 'loader'));
#	}
#
#	private function loader($className) {
#		$className = strtolower($className);
#		try {
#			include "{$className}.class.php";
#		} catch (Exception $e) {
#			echo "<div class='alert'><div class='error'>{$e->getMessage()}</div></div>";
#		}
#	}
#}

class AutoloadException extends Exception { }

class ClassAutoloader {

	public function __construct() {
		spl_autoload_register(array('ClassAutoloader', 'autoload'));
	}

    public static function autoload($class_name)
	{
		$class_name = strtolower($class_name);
		//if (class_exists($class_name))
        @include_once($class_name . '.class.php');

        // does the class requested actually exist now?
		if (class_exists($class_name)) {
			// yes, we're done
			return;
		}
    }
}

?>
