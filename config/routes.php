<?php

use Components\RouteComponent;

$router = new AltoRouter();

$router->map('get', '/', function() {
    var_dump(2);
    $this->routingController('DefaultController', 'home');
});

//$router->map('get', '/create', function() {
//    $this->routingController('DefaultController', 'home');
//});
//
//$router->map('post', '/edit', function() {
//    $this->routingController('DefaultController', 'home');
//});
//
//$router->map('post', '/add', function() {
//    $this->routingController('DefaultController', 'home');
//});

$rout = new RouteComponent($router);
$rout->routing();
