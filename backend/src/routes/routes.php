<?php
$routes = [
    'GET' => [
        '/taxs' => [
            'class' => 'Tax\\GetTax\\GetTaxfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/tax-only' => [
            'class' => 'Tax\\GetOnlyTax\\GetOnlyTaxfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-categorys' => [
            'class' => 'ProductCategory\\GetProductCategory\\GetProductCategoryfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-category-only' => [
            'class' => 'ProductCategory\\GetOnlyProductCategory\\GetOnlyProductCategoryFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/products' => [
            'class' => 'Product\\GetProduct\\GetProductFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-only' => [
            'class' => 'Product\\GetProduct\\GetProductFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/sales' => [
            'class' => 'Sales\\GetSales\\GetSalesFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ],
    'OPTIONS' => [
        '/taxs' => [
            'class' => 'Tax\\GetTax\\GetTaxfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-categorys' => [
            'class' => 'ProductCategory\\GetProductCategory\\GetProductCategoryfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/products' => [
            'class' => 'Product\\GetProduct\\GetProductFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/sales' => [
            'class' => 'Sales\\GetSales\\GetSalesFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/user-update' => [
            'class' => 'User\\UpdateUser\\UpdateUserFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/tax-update' => [
            'class' => 'Tax\\UpdateTax\\UpdateTaxfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-category-update' => [
            'class' => 'ProductCategory\\UpdateProductCategory\\UpdateProductCategoryfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-update' => [
            'class' => 'Product\\UpdateProduct\\UpdateProductFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/sales-update' => [
            'class' => 'Sales\\UpdateSales\\UpdateSalesFactory',
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
            'middlewares' => ['']
        ],
        '/product-category' => [
            'class' => 'ProductCategory\\CreateProductCategory\\CreateProductCategoryFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product' => [
            'class' => 'Product\\CreateProduct\\CreateProductFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/sales' => [
            'class' => 'Sales\\CreateSales\\CreateSalesFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/user-update' => [
            'class' => 'User\\UpdateUser\\UpdateUserFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/tax-update' => [
            'class' => 'Tax\\UpdateTax\\UpdateTaxfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-category-update' => [
            'class' => 'ProductCategory\\UpdateProductCategory\\UpdateProductCategoryfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-update' => [
            'class' => 'Product\\UpdateProduct\\UpdateProductFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/sales-update' => [
            'class' => 'Sales\\UpdateSales\\UpdateSalesFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
        '/tax-delete' => [
            'class' => 'Tax\\DeleteTax\\DeleteTaxfactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-category-delete' => [
            'class' => 'ProductCategory\\DeleteProductCategory\\DeleteProductCategoryFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/product-delete' => [
            'class' => 'Product\\DeleteProduct\\DeleteProductFactory',
            'action' => 'handle',
            'middlewares' => ['']
        ],
        '/sales-delete' => [
            'class' => 'Sales\\DeleteSales\\DeleteSalesFactory',
            'action' => 'handle',
            'middlewares' => ['VerifyTokenJWT']
        ],
    ],
];
