<?php

namespace Modules\ProductCategory\GetOnlyProductCategory;

use Exception;
use Modules\ProductCategory\GetOnlyProductCategory\GetOnlyProductCategoryCase;

class ProductCategoryGetOnlyController
{
    private $getOnlyProductCategory;

    public function __construct(GetOnlyProductCategoryCase $getOnlyProductCategory)
    {
        $this->getOnlyProductCategory = $getOnlyProductCategory;
    }

    public function handle()
    {
        try {
            $productCategory = $this->getOnlyProductCategory->execute();

            http_response_code(201);
            $response = $productCategory;

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
