<?php

namespace Modules\ProductCategory\CreateProductCategory;

use Entities\ProductCategory;

class CreateProductCategoryCase
{
    private $productCategoryRepository;

    public function __construct($productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data)
    {
        $categoryClass = new ProductCategory($data['name'], $data['tax_id']);

        $category = $this->productCategoryRepository->create($categoryClass);

        return $category;
    }
}
