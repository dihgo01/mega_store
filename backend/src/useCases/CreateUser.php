<?php

namespace UseCases;
use Exception;
use Repositories\UserCreateRepository;

class CreateUser
{
    private $userRepository;
    
    public function __construct()
    {
       $this->userRepository = new UserCreateRepository(); 
    }

    /**
     * @var array
     */
    public function execute($data)
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if ($user) {
            throw new Exception('User already exists.');
        }

        $user = $this->userRepository->create($data);
        
        return $user;
    }
}
