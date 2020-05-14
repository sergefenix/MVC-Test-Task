<?php

class DefaultController extends Controller
{
    public static function home($viewName)
    {
        self::view($viewName);
    }

    public static function create($viewName)
    {
        self::view($viewName);
    }

    public static function edit($viewName)
    {
        self::view($viewName);
    }

    public static function error($viewName)
    {
        self::view($viewName);
    }
}