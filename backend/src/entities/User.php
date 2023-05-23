<?php

namespace Entities;

class User
{
    public $name;
    public $email;
    public $password;

    public function __construct( string $name, string $email, string $password = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

}
