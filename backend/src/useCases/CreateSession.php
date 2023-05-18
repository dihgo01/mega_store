<?php

namespace UseCases;
use Exception;
use Repositories\SessionCreateRepository;
use Firebase\JWT\JWT;
use Dotenv\Dotenv;

class CreateSession
{
    private $sessionRepository;
    
    public function __construct()
    {
       $this->sessionRepository = new SessionCreateRepository(); 
    }

    /**
     * @var array
     */
    public function execute($data)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        $user = $this->sessionRepository->getUserLogin($data['email']);

        if (!$user) {
            throw new Exception('The email or password entered is incorrect.');
        }

        if(!password_verify($data['password'], $user->password)){
            throw new Exception('The email or password entered is incorrect.');
        }

        $payload = [
            'exp' => time() + 10000,
            'iat' => time(),
            'id' => $user->id,
        ];

        $encoded = JWT::encode($payload, $_ENV['SECRET_KEY'], 'HS256');

        return $encoded;
    }
}
