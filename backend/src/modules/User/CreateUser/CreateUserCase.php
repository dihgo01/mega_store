<?php

namespace Modules\User\CreateUser;

use Entities\User;
use Exception;

class CreateUserCase
{
    private $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data)
    {
        $userClass = new User($data['name'], $data['email'], $data['password']);

        $user = $userClass->create();

        $userExist = $this->userRepository->findByEmail($user['email']);

        if ($userExist) {
            throw new Exception('User already exists.');
        }

        $user = $this->userRepository->create($user);

        return $user;
    }
}
