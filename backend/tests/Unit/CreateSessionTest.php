<?php

use PHPUnit\Framework\TestCase;
use Repositories\Session\Memory\SessionCreateRepositoryMemory;
use Modules\Session\CreateSession\CreateSessionCase;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class CreateSessionTest extends TestCase
{
    private $sessionCreateRepository;
    private $createSession;

    protected function setUp(): void
    {
        $this->sessionCreateRepository = new SessionCreateRepositoryMemory();
        $this->createSession = new CreateSessionCase($this->sessionCreateRepository);
    }

    /** @test */
    public function should_be_able_to_create_a_new_session(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();

        $data = [
            'email' => 'test@gmail.com',
            'password' => '123456',
        ];

        $session = $this->createSession->execute($data);

        $decoded = JWT::decode($session, new Key($_ENV['SECRET_KEY'], 'HS256'));

        $this->assertEquals(1, $decoded->id);
    }

    /** @test */
    public function should_be_able_to_not_create_a_session(): void
    {
        $data = [
            'email' => 'test1@gmail.com',
            'password' => '123456',
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The email or password entered is incorrect');

        $this->createSession->execute($data);
    }
}
