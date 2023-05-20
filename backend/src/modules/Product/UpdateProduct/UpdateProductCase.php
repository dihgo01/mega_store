<?php

namespace Modules\Product\UpdateProduct;

use Entities\Product;
use Exception;

class UpdateProductCase
{
    private $productRepository;

    public function __construct($productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data, string $id)
    {
        $productExist = $this->productRepository->findByProduct($id);

        if (!$productExist) {
            throw new Exception('Product not found.');
        }

        $productClass = new Product($data['name_product'],$data['price'], $data['category_id']);
    
        $productResponse = $this->productRepository->update($productClass, $id);

        return $productResponse;
    }
}
