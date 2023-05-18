<?php 

use PHPUnit\Framework\TestCase;
use Database\Connection;
use Middlewares\VerifyTokenJWT;
use UseCases\CreateSession;
use UseCases\CreateUser;

class VerifyTokenTest extends TestCase {

    protected $token;

    /** @test */
    public function it_verify_middleware_token() {
        $response = [];
        $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODQ0NjIyMjIsImlhdCI6MTY4NDQ1MjIyMiwiaWQiOiJkMWIwMjRhZjlhNzgzN2E3Y2UxZDlhMjdkYjM1MGE1ZCJ9.Mh1GJdny2TrZyBnXojYy04pfoV2r-g2SGiMOyGlfH84";
        $middleware = new VerifyTokenJWT($token);
        $verify_token = $middleware->handle($response);

        $this->assertIsArray($verify_token);
    }
}