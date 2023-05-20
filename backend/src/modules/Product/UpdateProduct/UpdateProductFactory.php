<?php

namespace Modules\Product\UpdateProduct;

use Modules\Product\UpdateProduct\UpdateProductCase;
use Modules\Product\UpdateProduct\ProductUpdateController;
use Repositories\Product\ProductUpdateRepository;

class UpdateProductFactory {

    public function handle ($request) {
        $productRepository = new ProductUpdateRepository();
        $updateProduct = new UpdateProductCase($productRepository);
        $productUpdateController = new ProductUpdateController($updateProduct);
        return $productUpdateController->handle($request);
    }
}