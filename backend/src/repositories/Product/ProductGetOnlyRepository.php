<?php

namespace Repositories\Product;

use Database\Connection;
use Exception;
use PhpParser\Node\Expr\Cast\String_;

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
            $sql = "SELECT P.id AS id, P.name_product AS name, P.price AS price, PC.name AS category, PC.id AS category_id, P.created_at AS created_at
            FROM products P 
            INNER JOIN product_category PC ON P.category_id = PC.id  
            WHERE P.deleted_at IS NULL AND P.id = '$id'";

            $result = $this->connection->query($sql);
    
            return $result->fetch();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
