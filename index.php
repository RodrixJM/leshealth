<?php

define('DS',DIRECTORY_SEPARATOR);//   PLECA SEPARADOR
define('ROOT',realpath(dirname(__FILE__)).DS); // DIRECTORIO
define('APP_PATH',ROOT.'config'.DS); //  directorio config

require_once APP_PATH . 'Config.php';
require_once APP_PATH . 'Rutas.php';
require_once APP_PATH . 'Database.php';
require_once APP_PATH . 'Controller.php';
require_once APP_PATH . 'Model.php';
require_once APP_PATH . 'View.php';
require_once APP_PATH . 'Sessiones.php';
Sessiones::iniciar();
$rutas = new Rutas();
$rutas->run();