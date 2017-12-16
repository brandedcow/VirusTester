<?php

// set ROOT to main folder, .../VirusTester/
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
// set APP to /VirusTest/app/
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
// load application config (error reporting etc.)
require APP . 'config/config.php';

// load application class
require APP . 'core/application.php';
// load controller class
require APP . 'core/controller.php';
// start the application
$app = new Application();
?>
