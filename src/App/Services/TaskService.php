<?php

namespace App\Service;

use Components\DBComponent;

class TaskService
{
    protected $connect;
    protected $table;

    function __construct()
    {
        $this->connect = new DBComponent();
    }

    public function getAll()
    {
        $data = null;
        $sql="SELECT body, email, created_at  FROM todos ORDER by created_at desc";
        $pdo = $this->connect->getDb();
        if(!is_null($pdo)) {
            $data = $pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, "App\\Model\\Todo");
            $pdo = null;
        }

        return $data;
    }

    public function add($todo)
    {
        $count = 0;
        $sql = 'INSERT INTO todos (email, body) VALUES (:email, :body)';
        $pdo = $this->connect->getDb();
        if(!is_null($pdo)) {
            $sth = $pdo->prepare($sql);
            $count = $sth->execute(array(':email' => $todo->email, ':body' => $todo->body));
            $pdo = null;
        }
        return $count;
    }

    public function sortdescemail()
    {
        $data = null;
        $sql="SELECT username, body,email, created_at  FROM comments WHERE accepted = 1 ORDER by email desc";
        $pdo = $this->connect->getDb();
        if(!is_null($pdo)) {
            $data = $pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, "App\\Model\\Comment");
            $pdo = null;
        }

        return $data;
    }

    public function sortascemail()
    {
        $data = null;
        $sql="SELECT username, body,email, created_at  FROM comments WHERE accepted = 1 ORDER by email asc";
        $pdo = $this->connect->getDb();
        if(!is_null($pdo)) {
            $data = $pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, "App\\Model\\Comment");
            $pdo = null;
        }

        return $data;
    }

    public function sortdescdate()
    {
        $data = null;
        $sql="SELECT username, body,email, created_at  FROM comments WHERE accepted = 1 ORDER by created_at desc";
        $pdo = $this->connect->getDb();
        if(!is_null($pdo)) {
            $data = $pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, "App\\Model\\Comment");
            $pdo = null;
        }

        return $data;
    }

    public function sortascdate()
    {
        $data = null;
        $sql="SELECT username, body,email, created_at  FROM comments WHERE accepted = 1 ORDER by created_at asc";
        $pdo = $this->connect->getDb();
        if(!is_null($pdo)) {
            $data = $pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, "App\\Model\\Comment");
            $pdo = null;
        }

        return $data;
    }
}
