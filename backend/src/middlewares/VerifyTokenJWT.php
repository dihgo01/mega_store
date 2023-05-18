<?php 
namespace Middlewares;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class VerifyTokenJWT {
    protected $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function handle($request) {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        $token = $this->token;
        $token = str_replace('Bearer ', '', $token);
        
        if (!$token) {
            http_response_code(401);
            $response = [
                'message' => 'Token not found.',
            ];

            echo json_encode($response);
            exit;
        }

       try {
            $decoded = JWT::decode($token, new Key($_ENV['SECRET_KEY'], 'HS256'));
            $request['user_id'] = $decoded->id;

       } catch (\Exception $e) {
            http_response_code(401);
            $response = [
                'message' => $e->getMessage(),
            ];
            echo json_encode($response);
            exit;
        } 

        return $request;
    }
}