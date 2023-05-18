<?php

use PHPUnit\Framework\TestCase;

require_once 'src/routes/Router.php';

class RouterTest extends TestCase
{
    /** @test */
    public function should_get_route_not_found_error_message()
    {
        $this->expectException(Exception::class);

        $routes = [
            'GET' => [
                '/names' => [
                    'class' => 'Test',
                    'action' => 'index'
                ],
            ]
        ];

        $router = new Router\Router($routes);
        $router->verify_request('/names', 'GET');
    }
}
