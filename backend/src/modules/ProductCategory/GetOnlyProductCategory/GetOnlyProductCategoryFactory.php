<?php

namespace Modules\ProductCategory\GetOnlyProductCategory;

use Modules\ProductCategory\GetOnlyProductCategory\GetOnlyProductCategoryCase;
use Modules\ProductCategory\GetOnlyProductCategory\ProductCategoryGetOnlyController;
use Repositories\ProductCategory\ProductCategoryGetOnlyRepository;

class GetOnlyProductCategoryFactory {

    public function handle ($request) {
        $productCategoryRepository = new ProductCategoryGetOnlyRepository();
        $getOnlyProductCategory = new GetOnlyProductCategoryCase($productCategoryRepository);
        $productCategoryGetOnlyController = new ProductCategoryGetOnlyController($getOnlyProductCategory);
        return $productCategoryGetOnlyController->handle($request);
    }
}