<?php

namespace Components;

class DBComponent
{
    public static function Connection()
    {
        $paramsPath = 'Config/db_params.php';
        $params = include($paramsPath);

        try {
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
            $db = new PDO($dsn, $params['user'], $params['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("set names utf8");
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("A database error was encountered");
        }

        return $db;
    }

    public static function query($query, $params = [])
    {
        $statement = self::Connection()->prepare($query);
        $statement->execute($params);
        if (explode(' ', $query)[0] === "SELECT") {
            $data = $statement->fetchAll();
            return $data;
        }
    }
}