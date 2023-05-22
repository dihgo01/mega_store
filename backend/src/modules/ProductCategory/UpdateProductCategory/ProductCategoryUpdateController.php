<?php

namespace Modules\ProductCategory\UpdateProductCategory;

use Exception;
use Modules\ProductCategory\UpdateProductCategory\UpdateProductCategoryCase;

class ProductCategoryUpdateController
{
    private $updateProductCategory;

    public function __construct(UpdateProductCategoryCase $updateProductCategory)
    {
        $this->updateProductCategory = $updateProductCategory;
    }

    public function handle(array $request)
    {
        try {
            $id = $request['body']['id'];
            
            $productCategory = $this->updateProductCategory->execute($request['body'], $id);

            http_response_code(201);
            $response = [
                'message' => 'Successfully updated category!',
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
