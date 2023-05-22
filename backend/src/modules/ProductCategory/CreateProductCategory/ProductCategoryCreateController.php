<?php

namespace Modules\ProductCategory\CreateProductCategory;

use Exception;
use Modules\ProductCategory\CreateProductCategory\CreateProductCategoryCase;

class ProductCategoryCreateController
{
    private $createProductCategory;

    public function __construct(CreateProductCategoryCase $createProductCategory)
    {
        $this->createProductCategory = $createProductCategory;
    }

    public function handle($request)
    {
        try {
            $data = isset($request['body']);
            $category = $this->createProductCategory->execute($request['body']);

            http_response_code(201);
            $response = [
                'message' => 'Successfully registered category!',
                'data' => $category
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
