<?php

namespace Modules\Product\GetOnlyProduct;

use Exception;
use Modules\Product\GetOnlyProduct\GetOnlyProductCase;

class ProductGetOnlyController
{
    private $getOnlyProduct;

    public function __construct(GetOnlyProductCase $getOnlyProduct)
    {
        $this->getOnlyProduct = $getOnlyProduct;
    }

    public function handle(array $request)
    {
        try {
            $product = $this->getOnlyProduct->execute($request['body']['id']);

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
