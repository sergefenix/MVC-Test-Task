<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;


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
        $_POST['password'] = md5($_POST['password']);
        $user = new User($_POST);
        $result = $user->save();

        if ($result) {
            header('Location: ' . '/TaskManager/');
        } else {
            return false;
        }
    }

    public function login()
    {
        $this->view->render('login.html.twig');
    }

    public function login_user()
    {

        $password = md5($_POST['password']);
        $username = $_POST['username'];
        $user = new User();

        if ($user->login($username, $password)) {
            header('Location: ' . '/TaskManager/');
        } else {
            echo 'Ошибка';
            die();
        }

    }
}