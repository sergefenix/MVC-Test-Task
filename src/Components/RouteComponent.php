<?php

namespace Components;

class RouteComponent
{

    protected $params = [];
    private $routes;

    /**
     * RouteComponent constructor.
     */
    public function __construct($router)
    {
        $this->routes = $router;
    }


    public function routing()
    {
        $match = $this->router->match();
        $target = $match['target'];
        $param = $match['params'];

        if ($match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            // no route was matched
            $this->NotFound();
        }
    }

    //Не доработанная функция на ошибок
    public function routingController($controllerName, $action, $param = null)
    {
        $controllerName = "App\\Controller\\" . $controllerName;
        if (class_exists($controllerName)) {
            $controller = new $controllerName;
            if (method_exists($controller, $action)) {
                if (is_null($param)) {
                    $controller->$action();
                } else {
                    $controller->$action($param);
                }
            }
        } else {
            $this->NotFound();
        }
    }

    public function NotFound()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
        include('resources/views/404.php');
    }

}