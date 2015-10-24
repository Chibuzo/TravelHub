<?php

//define ("BASE_URL", "http://localhost/oya/");
//define ("CLASS_DIR", 'classes/');
define ("MODELS", 'models/');
define ("CONTROLLERS", 'controllers/');
//define ("VIEWS", 'views/');
//define ("LIB", 'lib/');
//define ("HELPERS", 'helpers/');

//set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
set_include_path(get_include_path().PATH_SEPARATOR.CONTROLLERS);
set_include_path(get_include_path().PATH_SEPARATOR.MODELS);
//set_include_path(get_include_path().PATH_SEPARATOR.VIEWS);
//set_include_path(get_include_path().PATH_SEPARATOR.LIB);
//set_include_path(get_include_path().PATH_SEPARATOR.HELPERS);
?>