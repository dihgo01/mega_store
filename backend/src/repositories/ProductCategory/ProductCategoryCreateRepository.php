<?php

namespace Repositories\ProductCategory;

use Entities\ProductCategory;

use Database\Connection;
use Exception;

class ProductCategoryCreateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var Entities\ProductCategory
     */
    public function create(ProductCategory $productCategory)
    {
        try {
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => md5(uniqid(rand(), true)),
                'name' => $productCategory->name,
                'tax_id' => $productCategory->tax_id,
                'created_at' => $date,
                'updated_at' => $date
            ];

            $sql = "INSERT INTO product_category (id, name, tax_id, created_at, updated_at) 
        VALUES (:id, :name, :tax_id, :created_at, :updated_at);";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            
            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
