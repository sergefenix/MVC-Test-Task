<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController extends Controller
{

    public $cook;

    /**
     * Redirect on home page
     */
    public function home()
    {
        $tasks = new Task();

        $paginator = new Task();
        $paginator = $paginator->page_paginator();

        if (isset($_GET['val'], $_GET['order'])) {
            $val = $_GET['val'];
            $order = $_GET['order'];
            $paginator['val'] = $val;
            $paginator['order'] = $order;
            $tasks = $tasks->select()->orderBy($val, $order)->paginate()->get();
        } else {
            $tasks = $tasks->select()->paginate()->get();
        }

        $data = ['tasks' => $tasks, 'cook' => $this->cook, 'paginator' => $paginator];
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

    /**
     *  Method for delete task
     */
    public function delete_tasks()
    {
        if ($this->cook) {
            $id = $_GET['id'];

            $task = new Task();
            $task->delete($id);

            header('Location: ' . '/TaskManager/');
        } else {
            echo 'This user does not have the necessary privileges';
            die();
        }
    }

    /**
     *  Method for update task status
     */
    public function update_tasks()
    {
        if ($this->cook) {
            $id = $_GET['id'];
            $status = $_GET['status'];

            $task = new Task();
            $task->update_status($id, $status);

            header('Location: ' . '/TaskManager/');
        } else {
            echo 'This user does not have the necessary privileges';
            die();
        }

    }

}