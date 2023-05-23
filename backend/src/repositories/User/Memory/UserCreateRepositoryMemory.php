<?php

namespace Repositories\User\Memory;

use Entities\User;

class UserCreateRepositoryMemory 
{
    protected $users = [];


    /**
     * @var string
     */
    public function findByEmail($email)
    {
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
    }

    /**
     * @var Entities\User
     */
    public function create(User $user)
    {   
        $user = [
            'id' => '1',
            'name' => $user->name,
            'email' => $user->email
        ];
        $this->users[] = $user;
        return $user;
    }
}
