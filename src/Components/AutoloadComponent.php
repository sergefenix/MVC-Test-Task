<?php

namespace Components;

class AutoloadComponent
{
    private $paths;

    public function __construct()
    {
        $this->paths = [
            './App/Controllers/',
            './App/Models/',
            './App/Components/'
        ];
    }

    public function Autoload()
    {
        spl_autoload_register(function ($class_name) {
            foreach ($this->paths as $path) {
                $path = $path . "$class_name.php";
                if (is_file($path)) {
                    require_once $path;
                }
            }
        });

        require('Config/routes.php');
    }
}