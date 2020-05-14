<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
define('ROOT', __FILE__);
session_start();

//use Components\AutoloadComponent;

require_once ('src\Components\AutoloadComponent.php');
$router = new AutoloadComponent();
$router->Autoload();