<?php

namespace Repositories\User\Memory;

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
     * @var array
     */
    public function create($user)
    {   
        $user['id'] = '1';
        $this->users[] = $user;
        return $user;
    }
}
