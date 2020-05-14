<?php

namespace Components;

use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigComponent
{
    private $template;

    public function __construct($template, $params)
    {
        $loader = new Twig_Loader_Filesystem($template);
        $this->template = new Twig_Environment($loader, $params);
    }

    public function render($template, $params = [])
    {
        echo $this->template->render($template, $params);
    }
}
