<?php

namespace Controllers;

use Exception;
use UseCases\CreateSession;

class SessionCreateController
{
    private $createSession;

    public function __construct()
    {
        $this->createSession = new CreateSession();
    }

    public function handle($request)
    {
        try {
            $session = $this->createSession->execute($request['body']);

            http_response_code(201);
            $response = [
                'message' => 'Login successful',
                'data' => $session
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
