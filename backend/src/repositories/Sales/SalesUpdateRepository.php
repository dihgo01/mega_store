<?php

namespace Repositories\Sales;

use Database\Connection;
use Exception;

use Entities\Sales;

class SalesUpdateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var string
     */
    public function findBySales(string $id, string $user_id)
    {
        $sql = "SELECT * FROM sales WHERE id = '{$id}' AND deleted_at IS NULL AND user_id = '{$user_id}'";
        $result = $this->connection->query($sql);

        return $result->fetch();
    }


    public function update(Sales $sales, string $id)
    {
        try {
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => $id,
                'price' => $sales->price,
                'status' => $sales->status,
                'updated_at' => $date
            ];

            $sql = "UPDATE sales SET price=:price, status=:status, updated_at=:updated_at WHERE id=:id";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            unset($data['id']);
            unset($data['user_id']);

            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
