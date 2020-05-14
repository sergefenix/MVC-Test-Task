<?php

namespace App\Controllers;

class Controller
{
    public $model;
    public $view;

    function __construct()
    {
        $template = array('src/app/views','src/app/views/templates');

        $params = array(
            'cache' => "tmp/cache",
            'auto_reload' => true,
            'autoescape' => true
        );

        $this->view = new TwigView($template, $params);
    }

    public static function view($viewName) {
        require_once("./Views/$viewName.php");
    }
}