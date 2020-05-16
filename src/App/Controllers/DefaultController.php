<?php

namespace App\Controllers;

use App\Models\Task;

class DefaultController extends Controller
{

    public $cook;

    /**
     * Redirect on home page
     */
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

        $data = ['tasks' => $tasks, 'cook' => $this->cook];
        $this->view->render('tasks.html.twig', $data);
    }

    /**
     * @return bool
     * Create task method
     */
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

    /**
     * Redirect on create task form
     */
    public function create_form()
    {
        $data = ['cook' => $this->cook];

        $this->view->render('create_task.html.twig', $data);
    }

}