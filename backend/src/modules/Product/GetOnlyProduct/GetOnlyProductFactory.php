<?php

namespace Modules\Product\GetOnlyProduct;

use Modules\Product\GetOnlyProduct\GetOnlyProductCase;
use Modules\Product\GetOnlyProduct\ProductGetOnlyController;
use Repositories\Product\ProductGetOnlyRepository;

class GetOnlyProductFactory {

    public function handle ($request) {
        $productRepository = new ProductGetOnlyRepository();
        $getOnlyProduct = new GetOnlyProductCase($productRepository);
        $productGetOnlyController = new ProductGetOnlyController($getOnlyProduct);
        return $productGetOnlyController->handle($request);
    }
}