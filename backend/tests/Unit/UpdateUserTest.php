<?php

use PHPUnit\Framework\TestCase;
use Repositories\User\Memory\UserUpdateRepositoryMemory;
use Modules\User\UpdateUser\UpdateUserCase;

class UpdateUserTest extends TestCase
{
    private $userUpdateRepository;
    private $updateUser;

    protected function setUp(): void
    {
        $this->userUpdateRepository = new UserUpdateRepositoryMemory();
        $this->updateUser = new UpdateUserCase($this->userUpdateRepository);
    }

    /** @test */
    public function should_be_able_to_update_a_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => '123456',
        ];

        $user = $this->updateUser->execute($data, '1');
        unset($data['password']);

        $this->assertEquals($data, $user);
    }

      /** @test */
      public function should_be_able_to_not_update_if_it_not_find_user(): void
      {
          $data = [
              'name' => 'John Doe',
              'email' => 'test@gmail.com',
              'password' => '123456',
          ];

          $this->expectException(Exception::class);
          $this->expectExceptionMessage('User not found.');
          $this->updateUser->execute($data, '10');
      }

    /** @test */
    public function should_be_able_to_not_update_if_another_user_with_email(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'test2@gmail.com',
            'password' => '123456',
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User already exists.');
        $this->updateUser->execute($data, '1');
    }
}
