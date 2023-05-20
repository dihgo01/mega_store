<?php

namespace Modules\Product\DeleteProduct;

use Modules\Product\DeleteProduct\DeleteProductCase;
use Modules\Product\DeleteProduct\ProductDeleteController;
use Repositories\Product\ProductDeleteRepository;

class DeleteProductFactory {

    public function handle ($request) {
        $productRepository = new ProductDeleteRepository();
        $deleteProduct = new DeleteProductCase($productRepository);
        $productDeleteController = new ProductDeleteController($deleteProduct);
        return $productDeleteController->handle($request);
    }
}