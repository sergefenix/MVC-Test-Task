<?php

class AutoloadComponent
{
    private $paths;

    public function __construct()
    {
        $this->paths = [
            'Controllers/',
            'Models/',
            'Components/',
            'System/'
        ];
    }

    public function Autoload()
    {
        spl_autoload_register(function ($class_name) {
            foreach ($this->paths as $path) {
                $path = $path . $class_name . '.php';
                if (is_file($path)) {
                    require_once $path;
                }
            }
        });
    }
}