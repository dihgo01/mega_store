<?php

namespace Modules\Product\DeleteProduct;

use Exception;
use Modules\Product\DeleteProduct\DeleteProductCase;

class ProductDeleteController
{
    private $deleteProduct;

    public function __construct(DeleteProductCase $deleteProduct)
    {
        $this->deleteProduct = $deleteProduct;
    }

    public function handle(array $request)
    {
        try {
            $product = $this->deleteProduct->execute($request['body']['id']);

            http_response_code(201);
            $response = [
                'message' => 'Successfully deleted product!',
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
