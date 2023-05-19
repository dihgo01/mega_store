<?php

namespace Repositories\Tax;

use Database\Connection;
use Exception;

class TaxGetRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

 
    public function list()
    {
        try {
            $sql = "SELECT * FROM taxs WHERE deleted_at IS NULL";
            $result = $this->connection->query($sql);
    
            return $result->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
