<?php

namespace Modules\ProductCategory\UpdateProductCategory;

use Entities\ProductCategory;
use Exception;

class UpdateProductCategoryCase
{
    private $productCategoryRepository;

    public function __construct($productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data, string $id)
    {
        $productCategoryExist = $this->productCategoryRepository->findByProductCategory($id);

        if (!$productCategoryExist) {
            throw new Exception('Category not found.');
        }

        $productCategoryClass = new ProductCategory($data['name'], $data['tax_id']);
    
        $productCategoryResponse = $this->productCategoryRepository->update($productCategoryClass, $id);

        return $productCategoryResponse;
    }
}
