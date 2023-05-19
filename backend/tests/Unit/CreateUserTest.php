<?php

use PHPUnit\Framework\TestCase;
use Repositories\User\Memory\UserCreateRepositoryMemory;
use Modules\User\CreateUser\CreateUserCase;

class CreateUserTest extends TestCase
{
    private $userCreateRepository;
    private $createUser;

    protected function setUp(): void
    {
        $this->userCreateRepository = new UserCreateRepositoryMemory();
        $this->createUser = new CreateUserCase($this->userCreateRepository);
    }

    /** @test */
    public function should_be_able_to_create_a_new_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => '123456',
        ];

        $user = $this->createUser->execute($data);

        $this->assertSame('1', $user['id']);
    }

    /** @test */
    public function must_not_register_users_exist(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => '123456',
        ];

        $this->createUser->execute($data);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User already exists');
        $this->createUser->execute($data);
    }
}
