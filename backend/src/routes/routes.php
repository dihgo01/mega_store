<?php
$routes = [
    'GET' => [
        '/taxs' => [
            'class' => 'Tax\\GetTax\\GetTaxfactory',
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
        '/tax' => [
            'class' => 'Tax\\CreateTax\\CreateTaxfactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ],
    'PUT' => [
        '/user-update' => [
            'class' => 'User\\UpdateUser\\UpdateUserFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/tax-update' => [
            'class' => 'Tax\\UpdateTax\\UpdateTaxfactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ],
    'DELETE' => [
        '/tax-delete' => [
            'class' => 'Tax\\DeleteTax\\DeleteTaxfactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ]
];
