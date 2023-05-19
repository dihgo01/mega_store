<?php

namespace Entities;

class User
{
    private $name;
    private $email;
    private $password;

    public function __construct( string $name, string $email, string $password = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @var array
     */
    public function create()
    {
        $user = ['name' => $this->name, 'email' => $this->email, 'password' => $this->password];
        return $user;
    }

    public function get()
    {
        $user = ['name' => $this->name, 'email' => $this->email];
        return $user;
    }
}
