<?php

namespace Repositories\Sales;

use Database\Connection;
use Exception;

class SalesGetRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

 
    public function list(string $id)
    {
        try {
            $sql = "SELECT id, price, status, created_at FROM sales WHERE deleted_at IS NULL and user_id = '{$id}'";

            $result = $this->connection->query($sql);
    
            return $result->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
