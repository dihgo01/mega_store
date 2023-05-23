<?php

namespace Repositories\User\Memory;

use Entities\User;
class UserUpdateRepositoryMemory
{
    protected $users = [];

    public function __construct()
    {
        $user1 = [
            'id' => '1',
            'name' => 'User Test',
            'email' => 'test@gmail.com',
            'password' => '$2y$10$QIZGS6A9bA1ecWHW6qFdMuf2DzQyDCsc3LW/i1.b8hlcxotPlUv8e'
        ];

        $user2 = [
            'id' => '2',
            'name' => 'User Test',
            'email' => 'test2@gmail.com',
            'password' => '$2y$10$QIZGS6A9bA1ecWHW6qFdMuf2DzQyDCsc3LW/i1.b8hlcxotPlUv8e'
        ];

        array_push($this->users, $user1);
        array_push($this->users, $user2);
    }

    /**
     * @var string
     */
    public function findByEmail(string $email)
    {
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return (object)$user;
            }
        }

        return [];
    }

    /**
     * @var string
     */
    public function findByUser(string $id)
    {
        foreach ($this->users as $user) {
            if ($user['id'] === $id) {
                return (object)$user;
            }
        }
        return false;
    }

    /**
     * @var Entities\User
     */
    public function update(User $user, string $id)
    {
        foreach ($this->users as $key => $item) {
            if ($item['id'] === $id) {
                $userUpdate = [
                    'id' => '1',
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => '$2y$10$QIZGS6A9bA1ecWHW6qFdMuf2DzQyDCsc3LW/i1.b8hlcxotPlUv8e'
                ];

                $this->users[$key] = $userUpdate;
                unset($userUpdate['id']);
                unset($userUpdate['password']);
                return $userUpdate;
            }
        }
    }
}
