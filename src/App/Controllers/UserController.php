<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{

    /**
     * @return bool
     * Register user method
     */
    public function register()
    {
        $_POST['password'] = md5($_POST['password']);
        $user = new User($_POST);

        $response = $user->select(['id'])->where('username', $_POST['username'])->get();

        if (!$response) {
            $result = $user->save();
        } else {
            echo 'This user already exist ';
            die();
        }

        if ($result) {
            header('Location: ' . '/TaskManager/');
        } else {
            return false;
        }
    }

    /**
     * Redirect on login page
     */
    public function login()
    {
        $this->view->render('login.html.twig');
    }

    /**
     * Login user method
     */
    public function login_user()
    {

        $password = md5($_POST['password']);
        $username = $_POST['username'];
        $user = new User();

        if ($user->login($username, $password)) {

            setcookie('user', $username, time() + 3600, '/');

            if ($user->is_admin($username)) {
                setcookie('admin', $username, time() + 3600, '/');
            }

            header('Location: ' . '/TaskManager/');
        } else {
            echo 'This user not found !';
            die();
        }

    }

    /**
     * Logout method
     */
    public function logout()
    {
        setcookie('user', '', time() - 3600, '/');
        setcookie('admin', '', time() - 3600, '/');
        header('Location: ' . '/TaskManager/');
    }

}