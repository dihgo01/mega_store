<?php

namespace Repositories;

use Database\Connection;
use Exception;

class SessionCreateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var string
     */
    public function getUserLogin($email)
    {
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $result = $this->connection->query($sql);

        return $result->fetch();
    }

}
