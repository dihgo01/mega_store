<?php

namespace Modules\Product\UpdateProduct;

use Exception;
use Modules\Product\UpdateProduct\UpdateProductCase;

class ProductUpdateController
{
    private $updateProduct;

    public function __construct(UpdateProductCase $updateProduct)
    {
        $this->updateProduct = $updateProduct;
    }

    public function handle(array $request)
    {
        try {
            $id = $request['body']['id'];
            $product = $this->updateProduct->execute($request['body'], $id);

            http_response_code(201);
            $response = [
                'message' => 'Successfully updated product!',
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
