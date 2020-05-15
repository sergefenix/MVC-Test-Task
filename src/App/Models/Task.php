<?php

namespace App\Models;

class Task extends Model
{
    public $email;
    public $name;
    public $text;
    public $table = 'tasks';
    public $img;
    public $author;


}