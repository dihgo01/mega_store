<?php

namespace Modules\Product\CreateProduct;

use Modules\Product\CreateProduct\CreateProductCase;
use Modules\Product\CreateProduct\ProductCreateController;
use Repositories\Product\ProductCreateRepository;

class CreateProductFactory {

    public function handle ($request) {
        $productRepository = new ProductCreateRepository();
        $createProduct = new CreateProductCase($productRepository);
        $productCreateController = new ProductCreateController($createProduct);
        return $productCreateController->handle($request);
    }
}