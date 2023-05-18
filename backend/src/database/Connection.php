<?php

namespace Database;
use PDO;
use PDOException;

class Connection {

    /**
     * Connect to the database
     * 
     * @param array $config
     * @return PDO
     */
    public static function connect($config): PDO {
        try {
            return new PDO(
                $config['connection'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['name'].";",
                $config['username'],
                $config['password'],
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}