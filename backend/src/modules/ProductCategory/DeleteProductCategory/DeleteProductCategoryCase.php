<?php

namespace Modules\ProductCategory\DeleteProductCategory;

use Exception;

class DeleteProductCategoryCase
{
    private $productCategoryRepository; 

    public function __construct($productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * @var array
     */
    public function execute(string $id)
    {
        $productCategoryExist = $this->productCategoryRepository->findByProductCategory($id);

        if (!$productCategoryExist) {
            throw new Exception('Category not found.');
        }
    
        $productCategoryResponse = $this->productCategoryRepository->delete($id);

        return $productCategoryResponse;
    }
}
