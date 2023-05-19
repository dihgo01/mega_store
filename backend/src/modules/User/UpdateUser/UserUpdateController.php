<?php

namespace Modules\User\UpdateUser;

use Exception;
use Modules\User\UpdateUser\UpdateUserCase;

class UserUpdateController
{
    private $updateUser;

    public function __construct(UpdateUserCase $updateUser)
    {
        $this->updateUser = $updateUser;
    }

    public function handle(array $request)
    {
        try {
            $user = $this->updateUser->execute($request['body'], $request['user_id']);

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
