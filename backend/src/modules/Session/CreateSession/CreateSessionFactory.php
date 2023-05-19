<?php
namespace Modules\Session\CreateSession;

use Modules\Session\CreateSession\CreateSessionCase;
use Modules\Session\CreateSession\SessionCreateController;
use Repositories\Session\SessionCreateRepository;

class CreateSessionFactory {

    public function handle ($request) {
        $sessionRepository = new SessionCreateRepository();
        $createSessionCase = new CreateSessionCase($sessionRepository);
        $sessionCreateController = new SessionCreateController($createSessionCase);
        return $sessionCreateController->handle($request);
    }
}