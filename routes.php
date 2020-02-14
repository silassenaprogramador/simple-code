<?php 

//
$route[] = ['/','Ssp\App\Controller\HomeController', 'index'];
$route[] = ['/exemplo','Ssp\App\Controller\HomeController', 'exemplo'];
$route[] = ['/exemplo/{10}','Ssp\App\Controller\HomeController', 'exemplo2'];


return $route;