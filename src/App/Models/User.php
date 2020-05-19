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
        $v = $this->select(['password'])->where('username', $login)->fetchColumn();

        return $password === $v;
    }

    public function is_admin($login)
    {
        return $this->select(['is_admin'])->where('username', $login)->fetchColumn();
    }
}