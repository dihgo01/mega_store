<?php

namespace Modules\Product\CreateProduct;

use Entities\Product;

class CreateProductCase
{
    private $productRepository;

    public function __construct($productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data)
    {
        $productClass = new Product($data['name_product'],$data['price'], $data['category_id']);

        $product = $this->productRepository->create($productClass);

        return $product;
    }
}
