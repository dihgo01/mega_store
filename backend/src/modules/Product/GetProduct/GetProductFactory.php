<?php

namespace Modules\Product\GetProduct;

use Modules\Product\GetProduct\GetProductCase;
use Modules\Product\GetProduct\ProductGetController;
use Repositories\Product\ProductGetRepository;

class GetProductFactory {

    public function handle ($request) {
        $productRepository = new ProductGetRepository();
        $getProduct = new GetProductCase($productRepository);
        $productGetController = new ProductGetController($getProduct);
        return $productGetController->handle($request);
    }
}