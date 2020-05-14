<?php

namespace App\Controllers;

use Components\TwigComponent;

class Controller
{
   // public $model;
    public $view;

    public function __construct()
    {
        $template = ['resources/views', 'resources/views/templates'];

        $params = [
            'cache'       => 'tmp/cache',
            'auto_reload' => true,
            'autoescape'  => true
        ];

        $this->view = new TwigComponent($template, $params);
    }
}