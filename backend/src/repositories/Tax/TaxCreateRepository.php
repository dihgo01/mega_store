<?php

namespace Repositories\Tax;

use Entities\Tax;

use Database\Connection;
use Exception;

class TaxCreateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var Entities\Tax
     */
    public function create(Tax $tax)
    {
        try {
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => md5(uniqid(rand(), true)),
                'name' => $tax->name,
                'percentage' => $tax->percentage,
                'created_at' => $date,
                'updated_at' => $date
            ];

            $sql = "INSERT INTO taxs (id, name, percentage, created_at, updated_at) 
        VALUES (:id, :name, :percentage, :created_at, :updated_at);";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            
            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
