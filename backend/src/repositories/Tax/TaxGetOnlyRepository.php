<?php

namespace Repositories\Tax;

use Database\Connection;
use Exception;

class TaxGetOnlyRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

 
    public function list(string $id)
    {
        try {
            $sql = "SELECT * FROM taxs WHERE deleted_at IS NULL AND id = '$id'";
            $result = $this->connection->query($sql);
    
            return $result->fetch();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
