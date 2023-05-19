<?php

namespace Modules\User\UpdateUser;

use Modules\User\UpdateUser\UpdateUserCase;
use Modules\User\UpdateUser\UserUpdateController;
use Repositories\User\UserUpdateRepository;

class UpdateUserFactory {

    public function handle ($request) {
        $userRepository = new UserUpdateRepository();
        $updateUser = new UpdateUserCase($userRepository);
        $userUpdateController = new UserUpdateController($updateUser);
        return $userUpdateController->handle($request);
    }
}