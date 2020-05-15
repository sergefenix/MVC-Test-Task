<?php

namespace App\Controllers;

use App\Models\Task;

class DefaultController extends Controller
{

    public function home()
    {
        $tasks = new Task();

        if ($_GET) {
            $val = $_GET['val'];
            $order = $_GET['order'];
            $tasks = $tasks->select()->orderBy($val, $order)->get();
        } else {
            $tasks = $tasks->getAll();
        }

        $data = ['tasks' => $tasks];
        $this->view->render('tasks.html.twig', $data);
    }

    public function create()
    {
        $task = new Task($_POST);
        $result = $task->save();

        if ($result) {
            header('Location: ' . '/TaskManager/');
        } else {
            return false;
        }
    }

    public function create_form()
    {
        $this->view->render('create_task.html.twig');
    }

    public function register()
    {
    }

    public function form_registration()
    {
    }

    public function login()
    {
        $this->view->render('login.html.twig');
    }
}