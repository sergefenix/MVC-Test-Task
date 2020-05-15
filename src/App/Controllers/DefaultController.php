<?php

namespace App\Controllers;

use App\Models\Task;

class DefaultController extends Controller
{
    public function home()
    {
        $tasks = new Task();
        $data = ['tasks' => $tasks->getAll()];
        $this->view->render('tasks.html.twig', $data);
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