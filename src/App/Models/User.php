<?php

namespace App\Models;

class User extends Model
{
    public $email;
    public $login;
    public $password;
    public $is_admin;

    public function login($login, $password)
    {
        $v = $this->select(['password'])->where('username', $login)->get('fetchColumn');

        return $password === $v;
    }
}