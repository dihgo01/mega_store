<?php

namespace Modules\ProductCategory\UpdateProductCategory;

use Modules\ProductCategory\UpdateProductCategory\UpdateProductCategoryCase;
use Modules\ProductCategory\UpdateProductCategory\ProductCategoryUpdateController;
use Repositories\ProductCategory\ProductCategoryUpdateRepository;

class UpdateProductCategoryFactory {

    public function handle ($request) {
        $productCategoryRepository = new ProductCategoryUpdateRepository();
        $updateProductCategory = new UpdateProductCategoryCase($productCategoryRepository);
        $productCategoryUpdateController = new ProductCategoryUpdateController($updateProductCategory);
        return $productCategoryUpdateController->handle($request);
    }
}