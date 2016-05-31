<?php

//define ("BASE_URL", "http://localhost/oya/");
//define ("CLASS_DIR", 'classes/');
define ("MODELS", 'models/');
define ("CONTROLLERS", 'controllers/');

//set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
set_include_path(get_include_path().PATH_SEPARATOR.CONTROLLERS);
set_include_path(get_include_path().PATH_SEPARATOR.MODELS);
?>