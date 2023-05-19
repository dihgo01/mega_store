<?php

namespace Repositories\ProductCategory;

use Database\Connection;
use Exception;

use Entities\ProductCategory;

class ProductCategoryUpdateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var string
     */
    public function findByProductCategory(string $id)
    {
        $sql = "SELECT * FROM product_category WHERE id = '{$id}' AND deleted_at IS NULL";
        $result = $this->connection->query($sql);

        return $result->fetch();
    }


    public function update(ProductCategory $productCategory, string $id)
    {
        try {
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => $id,
                'name' => $productCategory->name,
                'tax_id' => $productCategory->tax_id,
                'updated_at' => $date
            ];

            $sql = "UPDATE product_category SET name=:name, tax_id=:tax_id, updated_at=:updated_at WHERE id=:id";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            unset($data['id']);

            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
