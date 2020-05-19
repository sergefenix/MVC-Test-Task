<?php

namespace Components;

use AltoRouter;
use Components\Request;

class RouteComponent
{
    private $router;
    private $request;
    private $supportedHttpMethods =
        [
            'GET',
            'POST'
        ];

    /**
     * RouteComponent constructor.
     */
    public function __construct()
    {
        $this->router = new AltoRouter();
        $this->request = new Request();

        $this->router->map('get', '/TaskManager/', function () {
            $this->createRoute('TaskController', 'home');
        });

        $this->router->map('get', '/TaskManager/form_registration', function () {
            $this->createRoute('TaskController', 'form_registration');
        });

        $this->router->map('post', '/TaskManager/create', function () {
            $this->createRoute('TaskController', 'create');
        });

        $this->router->map('get', '/TaskManager/create_form', function () {
            $this->createRoute('TaskController', 'create_form');
        });

        $this->router->map('get', '/TaskManager/Metagram', function () {
            $this->createRoute('FindWayForWord', 'index');
        });

        $this->router->map('post', '/TaskManager/Metagram/create', function () {
            $this->createRoute('FindWayForWord', 'create');
        });

        $this->router->map('get', '/TaskManager/delete', function () {
            $this->createRoute('TaskController', 'delete_tasks');
        });

        $this->router->map('post', '/TaskManager/update', function () {
            $this->createRoute('TaskController', 'update_tasks');
        });

        $this->router->map('get', '/TaskManager/update_form', function () {
            $this->createRoute('TaskController', 'update_task_form');
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

    /**
     * @param $name
     * @param $args
     */
    public function __call($name, $args)
    {
        list($route, $method) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods, true)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param $route
     * @return string
     */
    private function formatRoute($route): string
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    /**
     *
     */
    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    /**
     *
     */
    private function defaultRequestHandler()
    {
        //header("{$this->request->serverProtocol} 404 Not Found");
    }

    /**
     * Resolves a route
     */
    public function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        $method = $methodDictionary[$formatedRoute];

        if ($method === null) {
            $this->defaultRequestHandler();
            return;
        }

        echo call_user_func_array($method, array($this->request));
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->resolve();
    }

}