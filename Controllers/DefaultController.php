<?php

class DefaultController extends Controller
{
    public static function home($viewName)
    {
        require_once ("./Views/$viewName");
    }

    public static function create($viewName)
    {
        require_once ("./Views/$viewName");
    }

    public static function edit($viewName)
    {
        require_once ("./Views/$viewName");
    }
}