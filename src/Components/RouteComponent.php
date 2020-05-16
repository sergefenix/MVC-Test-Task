<?php

namespace Components;

use AltoRouter;

class RouteComponent
{
    private $router;

    /**
     * RouteComponent constructor.
     */
    public function __construct()
    {
        $this->router = new AltoRouter();

        $this->router->map('get', '/TaskManager/', function () {
            $this->createRoute('DefaultController', 'home');
        });

        $this->router->map('get', '/TaskManager/form_registration', function () {
            $this->createRoute('DefaultController', 'form_registration');
        });

        $this->router->map('post', '/TaskManager/create', function () {
            $this->createRoute('DefaultController', 'create');
        });

        $this->router->map('get', '/TaskManager/create_form', function () {
            $this->createRoute('DefaultController', 'create_form');
        });


        $this->router->map('post', '/TaskManager/register', function () {
            $this->createRoute('UserController', 'register');
        });

        $this->router->map('get', '/TaskManager/login', function () {
            $this->createRoute('UserController', 'login');
        });

        $this->router->map('post', '/TaskManager/login_user', function () {
            $this->createRoute('UserController', 'login_user');
        });

        $this->router->map('get', '/TaskManager/logout', function () {
            $this->createRoute('UserController', 'logout');
        });
    }

    /**
     * RouteComponent creator routes
     */
    public function createRoutes()
    {
        $match = $this->router->match();
        $param = $match['params'];
        $target = $match['target'];

        if ($match && is_callable($target)) {
            call_user_func_array($target, $param);
        } else {
            $this->create404();
        }
    }

    /**
     * @param $controllerName
     * @param $action
     * @param null $param
     */
    public function createRoute($controllerName, $action, $param = null)
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
     * RouteComponent 404 page
     */
    public function create404()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
        include('resources/views/404.html.twig');
    }

}