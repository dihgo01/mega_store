<?php

namespace Modules\Product\GetProduct;

use Exception;
use Modules\Product\GetProduct\GetProductCase;

class ProductGetController
{
    private $getProduct;

    public function __construct(GetProductCase $getProduct)
    {
        $this->getProduct = $getProduct;
    }

    public function handle()
    {
        try {
            $product = $this->getProduct->execute();

            http_response_code(201);
            $response = $product;

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
