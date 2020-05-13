<?php

class RouteComponent
{
    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    public static $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * RouteComponent constructor.
     */
    public function __construct()
    {
        require('Config/routes.php');
    }

    public static function set($route, $function)
    {
        self::$routes[] = $route;
        if ($_SERVER['REQUEST_URI'] === "/TaskManager/$route") {
            $function->__invoke();
        } else {
            require_once ("./Views/404.php");
        }
    }

}