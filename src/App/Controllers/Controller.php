<?php

namespace App\Controllers;

use Components\Request;
use Components\TwigComponent;

class Controller
{
    public $view;
    protected $cook;
    protected $request;
    protected $is_admin;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $template = ['resources/views/templates', 'resources/views'];

        $params = [
            'cache'       => 'tmp/cache',
            'auto_reload' => true,
            'autoescape'  => true
        ];

        $this->request = new Request();
        $this->view = new TwigComponent($template, $params);
        $this->cook = $_COOKIE['user'] ?? false;
        $this->is_admin = $_COOKIE['admin'] ?? false;
    }
}