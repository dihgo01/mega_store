<?php

namespace Repositories\Product;

use Entities\Product;

use Database\Connection;
use Exception;

class ProductCreateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var Entities\Product
     */
    public function create(Product $product)
    {
        try {
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => md5(uniqid(rand(), true)),
                'name_product' => $product->name,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'created_at' => $date,
                'updated_at' => $date
            ];

            $sql = "INSERT INTO products (id, name_product, price, category_id, created_at, updated_at) 
        VALUES (:id, :name_product, :price ,:category_id, :created_at, :updated_at);";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);

            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
