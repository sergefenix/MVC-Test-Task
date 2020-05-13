<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT', __FILE__);
session_start();

require_once ('Components/AutoloadComponent.php');

$autoload = new AutoloadComponent();
$autoload->Autoload();

$router = new RouteComponent();
//$router->run();