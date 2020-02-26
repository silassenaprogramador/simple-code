<?php

if(!session_id()) session_start();

require "vendor/autoload.php";
require_once "System/Constant.php";
require_once "System/Eloquent.php";

$routes = require_once __DIR__ ."/routes.php";
$route = new Ssp\System\Route($routes);
