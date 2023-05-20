<?php

namespace Modules\Product\GetProduct;

class GetProductCase
{
    private $productRepository;

    public function __construct($productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function execute()
    {

        $product = $this->productRepository->list();

        return $product;
    }
}
