<?php

namespace Repositories\ProductCategory;

use Database\Connection;
use Exception;

class ProductCategoryGetRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

 
    public function list()
    {
        try {
            $sql = "SELECT PC.id AS id, PC.name AS category, T.name  AS tax, PC.created_at AS created_at
            FROM product_category PC 
            INNER JOIN taxs T ON PC.tax_id = T.id  
            WHERE PC.deleted_at IS NULL";

            $result = $this->connection->query($sql);
    
            return $result->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
