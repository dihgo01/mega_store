<?php

namespace Modules\ProductCategory\DeleteProductCategory;

use Exception;
use Modules\ProductCategory\DeleteProductCategory\DeleteProductCategoryCase;

class ProductCategoryDeleteController
{
    private $deleteProductCategory;

    public function __construct(DeleteProductCategoryCase $deleteProductCategory)
    {
        $this->deleteProductCategory = $deleteProductCategory;
    }

    public function handle(array $request)
    {
        try {
            $productCategory = $this->deleteProductCategory->execute($request['params']['id']);

            http_response_code(201);
            $response = [
                'message' => 'Successfully deleted category!',
                'data' => $productCategory
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
