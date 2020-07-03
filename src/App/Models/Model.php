<?php

namespace App\Models;

use Components\DBComponent;
use PDOStatement;
use PDO;

class Model
{

    public $id;

    private $page;

    private $query;

    protected $table;

    protected $connect;

    protected $per_page;

    /**
     * Model constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->connect = new DBComponent();
        $this->connect = $this->connect->Connection();

        if (is_null($this->table)) {
            $table = explode('\\', get_class($this));
            $str = end($table);
            preg_match_all('/[A-Z][^A-Z]*?/Us', $str, $match);
            $this->table = mb_strtolower(implode('_', $match[0])) . 's';
        }

        if ($params) {
            foreach ($params as $key => $value) {
                $this->$key = htmlspecialchars(trim($value));
            }
        }

        if ($this->per_page === null) {
            $this->per_page = 3;
        }

        $this->page = (int)($_GET['page'] ?? 1);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table ORDER by id desc LIMIT 0, $this->per_page";
        return $this->connect->query($sql)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM $this->table WHERE `id` = $id";
        return $this->connect->query($sql)->fetchAll();
    }

    /**
     * @param array $args
     *
     * @return Model
     */
    public function select(array $args = ['*']): self
    {
        $args = implode(', ', $args);
        $this->query = "SELECT $args FROM $this->table ";

        return $this;
    }

    /**
     * @param $prop
     * @param $val
     *
     * @return $this
     */
    public function where($prop, $val): self
    {
        $this->query .= "WHERE `$prop` = '$val'";
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        $sql = "SELECT count(*) as total from $this->table";
        return $this->connect->query($sql)->fetchColumn();
    }

    /**
     * @param string $order
     * @param string $sort
     *
     * @return Model
     */
    public function orderBy($order = 'id', $sort = 'desc'): self
    {
        $this->query .= "ORDER BY $order $sort";
        return $this;
    }

    /**
     * @return mixed
     */
    public function fetchAll()
    {
        $result = $this->connect->query($this->query)->fetchAll();
        $this->query = '';
        return $result;
    }

    /**
     * @return mixed
     */
    public function fetchColumn()
    {
        $result = $this->connect->query($this->query)->fetchColumn();
        $this->query = '';
        return $result;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $good = [];
        $block = ['connect', 'query', 'table', 'per_page', 'page'];
        $properties = get_object_vars($this);

        $sql = "INSERT INTO $this->table (";

        foreach ($properties as $key => $value) {
            if (!is_null($value) && !in_array($key, $block, true)) {
                $good[$key] = $value;
                $sql .= " $key,";
            }
        }

        $sql = substr_replace($sql, ') VALUES (', -1);

        foreach ($good as $value) {
            $sql .= " '$value', ";
        }

        $sql = substr_replace($sql, ')', -2);
        $result = $this->connect->query($sql);

        if ($result) {
            return true;
        }

        return false;
    }

    /**
     * @param $column
     * @param $value
     * @param $condition
     *
     * @return false|PDOStatement
     */
    public function update($column, $value, $condition)
    {
        $sql = "UPDATE $this->table SET $column = $value " . $condition;
        return $this->connect->query($sql);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = $id";
        return $this->connect->query($sql)->execute();
    }

    /**
     * @return Model
     */
    public function paginate(): Model
    {
        $offset = (($this->page - 1) * $this->per_page);
        $this->query .= " LIMIT $offset, $this->per_page";

        return $this;
    }

    /**
     * @return array
     */
    public function page_paginator(): array
    {
        $count = $this->getCount();
        $total_pages = ceil($count / $this->per_page);

        return
            [
                'page'       => $this->page,
                'total_page' => $total_pages
            ];
    }
}