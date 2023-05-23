<?php

namespace Modules\User\UpdateUser;

use Entities\User;
use Exception;

class UpdateUserCase
{
    private $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data, string $id)
    {
        $userExist = $this->userRepository->findByUser($id);

        if (!$userExist) {
            throw new Exception('User not found.');
        }

        if (isset($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $password = $userExist->password;
        }

        if ($userExist->email !== $data['email']) {
            $userFindEmail = $this->userRepository->findByEmail($data['email']);

            if ($userFindEmail) {
                throw new Exception('User already exists.');
            }
        }

        $user = new User($data['name'], $data['email'], $password);
    
        $userResponse = $this->userRepository->update($user, $id);

        return $userResponse;
    }
}
