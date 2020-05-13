<?php

class Controller
{
    public static function view($viewName) {
        require_once ("./Views/$viewName.php");
    }
}