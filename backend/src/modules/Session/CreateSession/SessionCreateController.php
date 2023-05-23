<?php

namespace Modules\Session\CreateSession;

use Exception;
use Modules\Session\CreateSession\CreateSessionCase;

class SessionCreateController
{
    private $createSession;

    public function __construct(CreateSessionCase $createSession)
    {
        $this->createSession = $createSession;
    }

    public function handle($request)
    {
        try {
            $session = $this->createSession->execute($request['body']);

            http_response_code(201);
            $response = [
                'message' => 'Login realizado com sucesso.',
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
