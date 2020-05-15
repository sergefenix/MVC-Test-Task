<?php

namespace App\Models;

use PDO;
use Components\DBComponent;

class Model
{
    public $id;
    public $table;
    private $query;
    private $connect;

    public function __construct()
    {
        $this->connect = new DBComponent();
        $this->connect = $this->connect->Connection();

        if (is_null($this->table)) {
            $table = explode('\\', get_class($this));
            $this->table = mb_strtolower(end($table)) . 's';
        }
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table ORDER by id desc";

        return $this->connect->query($sql)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    /**
     * @param array $args
     * @return Model
     */
    public function select(array $args = ['*'])
    {
        $args = implode(', ', $args);

        $this->query = "SELECT $args FROM $this->table ";

        return $this;
    }

    /**
     * @param string $order
     * @param string $sort
     * @return Model
     */
    public function orderBy($order = 'id', $sort = 'desc')
    {
        $this->query .= "ORDER BY $order $sort";

        return $this;
    }

    /**
     * @param string $fetch
     * @return mixed
     */
    public function get($fetch = 'fetchAll')
    {
        $result = $this->connect->query($this->query)->$fetch(PDO::FETCH_CLASS, static::class);
        $this->query = '';
        return $result;
    }
}