<?php

namespace Repositories\Session\Memory;

class SessionCreateRepositoryMemory
{
    protected $users = [];

    public function __construct()
    {
        $this->users[] = [
            'id' => '1',
            'name' => 'User Test',
            'email' => 'test@gmail.com',
            'password' => '$2y$10$QIZGS6A9bA1ecWHW6qFdMuf2DzQyDCsc3LW/i1.b8hlcxotPlUv8e'
        ];
    }

    /**
     * @var string
     */
    public function getUserLogin($email)
    {
        foreach($this->users as $user) { 
            if ($user['email'] === $email) {
                return (object)$user;
            }
        }

        return [];
    }
}
