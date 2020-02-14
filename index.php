<?php

if(!session_id()) session_start();

require "vendor/autoload.php";

require_once "System/Constant.php";

$routes = require_once __DIR__ ."/routes.php";

$route = new Ssp\System\Route($routes);
