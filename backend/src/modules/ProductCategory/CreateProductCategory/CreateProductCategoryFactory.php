<?php

namespace Modules\ProductCategory\CreateProductCategory;

use Modules\ProductCategory\CreateProductCategory\CreateProductCategoryCase;
use Modules\ProductCategory\CreateProductCategory\ProductCategoryCreateController;
use Repositories\ProductCategory\ProductCategoryCreateRepository;

class CreateProductCategoryFactory {

    public function handle ($request) {
        $productCategoryRepository = new ProductCategoryCreateRepository();
        $createProductCategory = new CreateProductCategoryCase($productCategoryRepository);
        $productCategoryCreateController = new ProductCategoryCreateController($createProductCategory);
        return $productCategoryCreateController->handle($request);
    }
}