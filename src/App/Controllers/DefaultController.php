<?php

namespace App\Controllers;

use TaskModel;

class DefaultController extends Controller
{
    public function home()
    {
        $tasks =  [];//$this->todoService->getAll();
        $data = ['tasks' => $tasks];
        $this->view->render('tasks.html.twig', $data);
    }

//    public static function create($viewName)
//    {
//        self::view($viewName);
//    }
//
//    public static function edit($viewName)
//    {
//        self::view($viewName);
//    }
//
//    public static function error($viewName)
//    {
//        self::view($viewName);
//    }
}