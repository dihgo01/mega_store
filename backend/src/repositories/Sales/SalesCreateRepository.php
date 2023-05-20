<?php

namespace Repositories\Sales;

use Entities\Sales;

use Database\Connection;
use Exception;

class SalesCreateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var Entities\Sales
     * @var array
     */
    public function create(Sales $sales, array $products)
    {
        try {
            $date = date('Y-m-d H:i:s');
            $id_sales = md5(uniqid(rand(), true));
            $product_array = [];

            $data = [
                'id' => $id_sales,
                'user_id' => $sales->user_id,
                'price' => $sales->price,
                'status' => $sales->status,
                'created_at' => $date,
                'updated_at' => $date
            ];

            $sql = "INSERT INTO sales (id, user_id, price, status, created_at, updated_at) 
        VALUES (:id, :user_id, :price ,:status, :created_at, :updated_at);";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);

            foreach($products as $product) {
                $data_product = [
                    'id' => md5(uniqid(rand(), true)),
                    'sales_id' => $id_sales,
                    'product_id' => $product->product_id,
                    'amount' => $product->amount,
                    'price' => $product->price,
                    'created_at' => $date,
                    'updated_at' => $date
                ];

                $sql = "INSERT INTO sales_product (id, sales_id, product_id, amount, price, created_at, updated_at) 
                VALUES (:id, :sales_id, :product_id ,:amount, :price, :created_at, :updated_at);";

                $result_product = $this->connection->prepare($sql);
                $reponse_product_query = $result_product->execute($data_product);
                $product_array[] = $data_product;
            }
            $data['products'] = $product_array;

            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
