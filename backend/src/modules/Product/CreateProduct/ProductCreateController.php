<?php

namespace Modules\Product\CreateProduct;

use Exception;
use Modules\Product\CreateProduct\CreateProductCase;

class ProductCreateController
{
    private $createProduct;

    public function __construct(CreateProductCase $createProduct)
    {
        $this->createProduct = $createProduct;
    }

    public function handle($request)
    {
        try {
            $product = $this->createProduct->execute($request['body']);

            http_response_code(201);
            $response = [
                'message' => 'Successfully registered product!',
                'data' => $product
            ];

            echo json_encode($response);
        } catch (Exception $e) {

            http_response_code(401);
            $response = [
                'message' => $e->getMessage(),
            ];

            echo json_encode($response);
        }
    }
}
