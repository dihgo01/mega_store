<?php

namespace Controllers;

use Exception;
use UseCases\CreateUser;

class UserCreateController
{
    private $createUser;

    public function __construct()
    {
        $this->createUser = new CreateUser();
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
