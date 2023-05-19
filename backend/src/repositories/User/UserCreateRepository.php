<?php

namespace Repositories\User;

use Entities\User;

use Database\Connection;
use Exception;

class UserCreateRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * @var string
     */
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $result = $this->connection->query($sql);

        return $result->fetch();
    }

    /**
     * @var Entities\User
     */
    public function create(User $user)
    {
        try {

            $password = password_hash($user['password'], PASSWORD_DEFAULT);
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => md5(uniqid(rand(), true)),
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $password,
                'created_at' => $date,
                'updated_at' => $date
            ];

            $sql = "INSERT INTO users (id, name, email, password, created_at, updated_at) 
        VALUES (:id, :name, :email, :password, :created_at, :updated_at);";

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            unset($data['password']);
            
            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }
}
