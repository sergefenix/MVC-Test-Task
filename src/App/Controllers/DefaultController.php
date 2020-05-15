<?php

namespace App\Controllers;

use App\Models\TaskModel;

class DefaultController extends Controller
{
    public function home()
    {
        $tasks = new TaskModel();
        $data = ['tasks' => $tasks->getAll()];
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