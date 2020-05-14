<?php

namespace App\Controllers;

use Components\TwigComponent;

class Controller
{
    public $model;
    public $view;

    public function __construct()
    {
        $template = ['resource/views', 'resource/views/templates'];

        $params = [
            'cache'       => 'tmp/cache',
            'auto_reload' => true,
            'autoescape'  => true
        ];

        $this->view = new TwigComponent($template, $params);
    }

    public static function view($viewName)
    {
        require_once("resources/views/$viewName.php");
    }
}