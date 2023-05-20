<?php

namespace Modules\Product\DeleteProduct;

use Exception;

class DeleteProductCase
{
    private $productRepository; 

    public function __construct($productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @var array
     */
    public function execute(string $id)
    {
        $productExist = $this->productRepository->findByProduct($id);

        if (!$productExist) {
            throw new Exception('Product not found.');
        }
    
        $productResponse = $this->productRepository->delete($id);

        return $productResponse;
    }
}
