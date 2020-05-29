<?php

namespace Components;

use PDO;
use PDOException;

class DBComponent
{
    /**
     * @return PDO
     */
    public static function Connection(): PDO
    {
        $paramsPath = 'config/db_params.php';
        $params = include($paramsPath);

        try {
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
            $db = new PDO($dsn, $params['user'], $params['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec('set names utf8');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die('A database error was encountered');
        }

        return $db;
    }

    /**
     * @param $query
     * @param array $params
     * @return array|null
     */
    public static function query($query, $params = []): ?array
    {
        $statement = self::Connection()->prepare($query);
        $statement->execute($params);
        if (explode(' ', $query)[0] === 'SELECT') {
            return $statement->fetchAll();
        }
    }
}