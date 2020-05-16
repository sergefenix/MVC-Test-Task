<?php

namespace App\Models;

use PDO;
use Components\DBComponent;

class Model
{
    public $id;

    private $query;

    protected $connect;

    protected $table;

    /**
     * Model constructor.
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
     * @param $prop
     * @param $val
     * @return $this
     */
    public function where($prop, $val)
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
        $result = $this->connect->query($this->query)->$fetch();
        $this->query = '';
        return $result;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $good = [];
        $block = ['connect', 'query', 'table'];
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
     * @param array $properties
     */
    public function update(array $properties)
    {

    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = $id";

        return $this->connect->query($sql)->execute();
    }
}