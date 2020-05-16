<?php

namespace App\Models;

class Task extends Model
{
    public $name;
    public $email;
    public $text;
    public $img;
    public $author;

    public function update_status($id, $status = 0)
    {
        $sql = "UPDATE $this->table SET `status` = $status WHERE `id` = $id";
        return $this->connect->query($sql)->execute();
    }

    public function delete_img($id)
    {
        unlink('public/downloads/' . $id);
    }
}