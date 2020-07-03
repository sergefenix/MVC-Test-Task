<?php

namespace Components;

use AltoRouter;
use Exception;

class Route
{
    private $router;
    public $request;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->router = new AltoRouter();
        $this->request = new Request();
    }

    /**
     * Route creator routes
     */
    public function createRoutes(): void
    {
        $match = $this->router->match();
        $param = $match['params'] ?? null;
        $target = $match['target'] ?? null;

        if ($match && is_callable($target)) {
            call_user_func_array($target, $param);
        } else {
            $this->create404();
        }
    }

    /**
     * @param      $route
     * @param      $target
     * @param null $name
     *
     * @throws Exception
     */
    public function get($route, $target, $name = null): void
    {
        $this->router->map('get', $route, $target, $name);
    }

    /**
     * @param      $route
     * @param      $target
     * @param null $name
     *
     * @throws Exception
     */
    public function post($route, $target, $name = null): void
    {
        $this->router->map('post', $route, $target, $name);
    }

    /**
     * @param      $controllerName
     * @param      $action
     * @param null $param
     */
    public function createRoute($controllerName, $action, $param = null): void
    {
        $controllerName = "App\Controllers\\" . $controllerName;

        if (class_exists($controllerName)) {
            $controller = new $controllerName();

            if (method_exists($controller, $action) && $param === null) {
                $controller->$action();
            } elseif (method_exists($controller, $action) && $param !== null) {
                $controller->$action($param);
            }
        } else {
            $this->create404();
        }
    }

    /**
     * Route 404 page
     */
    public function create404(): void
    {
        include('resources/views/404.html.twig');
    }
}