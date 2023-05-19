<?php

namespace Modules\ProductCategory\GetProductCategory;

use Modules\ProductCategory\GetProductCategory\GetProductCategoryCase;
use Modules\ProductCategory\GetProductCategory\ProductCategoryGetController;
use Repositories\ProductCategory\ProductCategoryGetRepository;

class GetProductCategoryFactory {

    public function handle ($request) {
        $productCategoryRepository = new ProductCategoryGetRepository();
        $getProductCategory = new GetProductCategoryCase($productCategoryRepository);
        $productCategoryGetController = new ProductCategoryGetController($getProductCategory);
        return $productCategoryGetController->handle($request);
    }
}