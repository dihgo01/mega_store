<?php

namespace Modules\User\CreateUser;

use Exception;
use Modules\User\CreateUser\CreateUserCase;

class UserCreateController
{
    private $createUser;

    public function __construct(CreateUserCase $createUser)
    {
        $this->createUser = $createUser;
    }

    public function handle($request)
    {
        try {
            $user = $this->createUser->execute($request['body']);

            http_response_code(201);
            $response = [
                'message' => 'Successfully registered user!',
                'data' => $user
            ];

            echo json_encode($response);
        } catch (Exception $e) {

            http_response_code(401);
            $response = [
                'message' => $e->getMessage(),
            ];

            echo json_encode($response);
        }
    }
}
