<?php

namespace Repositories\User;

use Database\Connection;
use Exception;

class UserUpdateRepository
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
     * @var string
     */
    public function findByUser(string $id)
    {
        $sql = "SELECT * FROM users WHERE id = '{$id}'";
        $result = $this->connection->query($sql);

        return $result->fetch();
    }

    
    public function update($user, string $id)
    {
        try {
            $password = $user->password;
            $date = date('Y-m-d H:i:s');

            $data = [
                'id' => $id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
                'updated_at' => $date
            ];

            $sql = "UPDATE users SET name=:name, email=:email, password=:password, updated_at=:updated_at WHERE id=:id"; 

            $result = $this->connection->prepare($sql);
            $reponse_query = $result->execute($data);
            unset($data['id']);
            unset($data['password']);
            
            return $reponse_query === true ? $data : false;
        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }
}
