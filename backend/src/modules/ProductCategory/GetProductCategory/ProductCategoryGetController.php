<?php

namespace Modules\ProductCategory\GetProductCategory;

use Exception;
use Modules\ProductCategory\GetProductCategory\GetProductCategoryCase;

class ProductCategoryGetController
{
    private $getProductCategory;

    public function __construct(GetProductCategoryCase $getProductCategory)
    {
        $this->getProductCategory = $getProductCategory;
    }

    public function handle()
    {
        try {
            $productCategory = $this->getProductCategory->execute();

            http_response_code(201);
            $response = [
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
