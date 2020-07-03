<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{

    /**
     * @return bool
     * Register user method
     */
    public function register(): ?bool
    {
        $body = $this->request->getBody();
        $body['password'] = md5($body['password']);
        $user = new User($body);

        $response = $user->select(['id'])->where('username', $body['username'])->fetchAll();

        if (!$response) {
            $result = $user->save();
        } else {
            die('This user already exist');
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
        $body = $this->request->getBody();
        $password = md5($body['password']);
        $username = $body['username'];
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
    public function logout(): void
    {
        setcookie('user', '', time() - 3600, '/');
        setcookie('admin', '', time() - 3600, '/');
        header('Location: ' . '/TaskManager/');
    }

}