<?php

namespace Repositories\Product;

use Database\Connection;
use Exception;

class ProductGetRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

 
    public function list()
    {
        try {
            $sql = "SELECT P.id AS id, P.name_product AS name, P.price AS price, PC.name AS category, P.created_at AS created_at
            FROM products P 
            INNER JOIN product_category PC ON P.category_id = PC.id  
            WHERE P.deleted_at IS NULL";

            $result = $this->connection->query($sql);
    
            return $result->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
