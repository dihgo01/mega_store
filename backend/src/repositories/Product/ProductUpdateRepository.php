<?php

namespace Repositories\Product;

use Database\Connection;
use Exception;

use Entities\Product;

class ProductUpdateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var string
     */
    public function findByProduct(string $id)
    {
        $sql = "SELECT * FROM products WHERE id = '{$id}' AND deleted_at IS NULL";
        $result = $this->connection->query($sql);

        return $result->fetch();
    }


    public function update(Product $product, string $id)
    {
        try {
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => $id,
                'name_product' => $product->name,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'updated_at' => $date
            ];

            $sql = "UPDATE products SET name_product=:name_product, price=:price, category_id=:category_id, updated_at=:updated_at WHERE id=:id";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            unset($data['id']);

            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
