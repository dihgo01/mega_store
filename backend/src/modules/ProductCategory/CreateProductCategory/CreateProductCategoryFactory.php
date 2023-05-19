<?php

namespace Modules\ProductCategory\CreateProductCategory;

use Modules\ProductCategory\CreateProductCategory\CreateProductCategoryCase;
use Modules\ProductCategory\CreateProductCategory\ProductCategoryCreateController;
use Repositories\ProductCategory\ProductCategoryCreateRepository;

class CreateProductCategoryFactory {

    public function handle ($request) {
        $ProductCategoryRepository = new ProductCategoryCreateRepository();
        $createProductCategory = new CreateProductCategoryCase($ProductCategoryRepository);
        $ProductCategoryCreateController = new ProductCategoryCreateController($createProductCategory);
        return $ProductCategoryCreateController->handle($request);
    }
}