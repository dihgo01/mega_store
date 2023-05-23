<?php

namespace Modules\User\CreateUser;

use Modules\User\CreateUser\CreateUserCase;
use Modules\User\CreateUser\UserCreateController;
use Repositories\User\UserCreateRepository;

class CreateUserfactory {

    public function handle($request) {
        $userRepository = new UserCreateRepository();
        $createUser = new CreateUserCase($userRepository);
        $userCreateController = new UserCreateController($createUser);
        return $userCreateController->handle($request);
    }
}