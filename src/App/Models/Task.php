<?php

namespace App\Models;

class Task extends Model
{
    public $name;
    public $email;
    public $text;
    public $img;
    public $author;

    public function update_status($post)
    {
        $status = ($post['status'] == 'on') ? 1 : 0;
        $name = $post['name'];
        $email = $post['email'];
        $text = $post['text'];
        $id = $post['id'];

        $sql = "UPDATE $this->table SET `status` = '$status', `name` = '$name', `email` = '$email', `text` = '$text' WHERE `id` = $id";
        return $this->connect->query($sql)->execute();
    }

    public function delete_img($id)
    {
        unlink('public/downloads/' . $id);
    }
}