<?php

namespace Repositories\Product;

use Database\Connection;
use Exception;

class ProductGetOnlyRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

 
    public function list(string $id)
    {
        try {
            $sql = "SELECT P.id AS id, 
            P.name_product AS name, 
            P.price AS price, 
            PC.name AS category, 
            T.percentage AS percentage,
            PC.id AS category_id, P.created_at AS created_at
            FROM products P 
            INNER JOIN product_category PC ON P.category_id = PC.id  
            INNER JOIN taxs T ON PC.tax_id = T.id
            WHERE P.deleted_at IS NULL AND P.id = '$id'";

            $result = $this->connection->query($sql);
    
            return $result->fetch();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
