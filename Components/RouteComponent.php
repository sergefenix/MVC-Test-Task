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
            $this->routes = require('Config/routes.php');
        }

        public static function set($route, $function) {

            self::$routes[] = $route;

            if ($_GET['url'] == $route) {
                $function->__invoke();
            }
        }

        public function add($route, $params = [])
        {
            // Convert the route to a regular expression: escape forward slashes
            $route = preg_replace('/\//', '\\/', $route);

            // Convert variables e.g. {controller}
            $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

            // Convert variables with custom regular expressions e.g. {id:\d+}
            $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

            // Add start and end delimiters, and case insensitive flag
            $route = '/^' . $route . '$/i';

            $this->routes[$route] = $params;
        }

        /**
         * Get all the routes from the routing table
         *
         * @return array
         */
        public function getRoutes()
        {
            return $this->routes;
        }

    }