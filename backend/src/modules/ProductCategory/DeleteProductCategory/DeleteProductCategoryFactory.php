<?php

namespace Modules\ProductCategory\DeleteProductCategory;

use Modules\ProductCategory\DeleteProductCategory\DeleteProductCategoryCase;
use Modules\ProductCategory\DeleteProductCategory\ProductCategoryDeleteController;
use Repositories\ProductCategory\ProductCategoryDeleteRepository;

class DeleteProductCategoryFactory {

    public function handle ($request) {
        $productCategoryRepository = new ProductCategoryDeleteRepository();
        $deleteProductCategory = new DeleteProductCategoryCase($productCategoryRepository);
        $productCategoryDeleteController = new ProductCategoryDeleteController($deleteProductCategory);
        return $productCategoryDeleteController->handle($request);
    }
}