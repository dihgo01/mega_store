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

    public function handle(array $request)
    {
        try {
            $productCategory = $this->getOnlyProductCategory->execute($request['body']['id']);

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
