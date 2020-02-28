<?php

if(!session_id()) session_start();

/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);

/* Habilita a exibição de erros */
ini_set("display_errors", 1);

require "vendor/autoload.php";
require_once "System/Constant.php";
require_once "System/Database.php";

$routes = require_once __DIR__ ."/routes.php";
$route = new Ssp\System\Route($routes);
