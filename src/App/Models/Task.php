<?php

namespace App\Models;

class Task extends Model
{

    protected $table = 'tasks';

    public $name;
    public $email;
    public $text;
    public $img;
    public $author;


}