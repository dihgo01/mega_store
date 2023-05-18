<?php
namespace Database;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Connection
{

    /**
     * Connect to the database
     * 
     * @param array $config
     * @return PDO
     */
    public static function connect(): PDO
    {
        try {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
            $dotenv->load();
        
            return new PDO(
                $_ENV['DB_CONNECTION'] . ':host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_DATABASE'] . ";",
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
