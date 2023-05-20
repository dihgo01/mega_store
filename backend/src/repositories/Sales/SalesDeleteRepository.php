<?php

namespace Repositories\Sales;

use Database\Connection;
use Exception;

class SalesDeleteRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var string
     */
    public function findBySales(string $id)
    {
        $sql = "SELECT * FROM sales WHERE id = '{$id}' AND deleted_at IS NULL";
        $result = $this->connection->query($sql);

        return $result->fetch();
    }


    public function delete(string $id)
    {
        try {
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => $id,
                'deleted_at' => $date
            ];

            $sql = "UPDATE sales SET deleted_at=:deleted_at WHERE id=:id";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            unset($data['id']);

            return $reponse_query ;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
