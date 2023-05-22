<?php

namespace Modules\Product\GetOnlyProduct;

class GetOnlyProductCase
{
    private $productRepository;

    public function __construct($productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function execute(string $id)
    {
        $product = $this->productRepository->list($id);

        return $product;
    }
}
