<?php
$routes = [
    'GET' => [
        '/names/teste' => [
            'class' => 'UserController',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ],
    'POST' => [
        '/users' => [
            'class' => 'UserCreateController',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/session' => [
            'class' => 'SessionCreateController',
            'action' => 'handle',
            'middlewares' => ['']
        ],
    ],
    'PUT' => [
        '/names' => [
            'class' => 'User',
            'action' => 'index'
        ],
        '/' => [
            'class' => 'UserController',
            'action' => 'handle'
        ],
    ],
    'DELETE' => [
        '/names' => [
            'class' => 'User',
            'action' => 'index'
        ],
        '/' => [
            'class' => 'UserController',
            'action' => 'handle'
        ],
    ]
];
