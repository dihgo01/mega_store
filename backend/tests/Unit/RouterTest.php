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
                '/' => [
                    'class' => 'Test',
                    'action' => 'index'
                ],
            ]
        ];

        $router = new Router\Router($routes);

        $request = [
            'uri' => '/names',
            'method' => 'GET',
            'body' => null,
            'params' => null
        ];

        $router->verify_request($request);
    }

    /** @test */
    public function should_get_action_not_found_error_message()
    {
        $this->expectException(Exception::class);

        $routes = [
            'GET' => [
                '/' => [
                    'class' => 'UserController',
                    'action' => 'index'
                ],
            ]
        ];

        $router = new Router\Router($routes);

        $request = [
            'uri' => '/',
            'method' => 'GET',
            'body' => null,
            'params' => null
        ];

        $router->verify_request($request);
    }
}
