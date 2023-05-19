<?php
$routes = [
    'GET' => [
        '/user' => [
            'class' => 'User\\GetUser\\GetUserfactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ],
    'POST' => [
        '/users' => [
            'class' => 'User\\CreateUser\\CreateUserfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/session' => [
            'class' => 'Session\\CreateSession\\CreateSessionFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
    ],
    'PUT' => [
        '/user-update' => [
            'class' => 'User\\UpdateUser\\UpdateUserFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
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
