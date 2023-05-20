<?php
$routes = [
    'GET' => [
        '/taxs' => [
            'class' => 'Tax\\GetTax\\GetTaxfactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/product-categorys' => [
            'class' => 'ProductCategory\\GetProductCategory\\GetProductCategoryfactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/products' => [
            'class' => 'Product\\GetProduct\\GetProductFactory',
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
        '/product-category' => [
            'class' => 'ProductCategory\\CreateProductCategory\\CreateProductCategoryFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/product' => [
            'class' => 'Product\\CreateProduct\\CreateProductFactory',
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
        '/product-category-update' => [
            'class' => 'ProductCategory\\UpdateProductCategory\\UpdateProductCategoryfactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/product-update' => [
            'class' => 'Product\\UpdateProduct\\UpdateProductFactory',
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
        '/product-category-delete' => [
            'class' => 'ProductCategory\\DeleteProductCategory\\DeleteProductCategoryFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/product-delete' => [
            'class' => 'Product\\DeleteProduct\\DeleteProductFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ]
];
