<?php

namespace Repositories\ProductCategory\Memory;

use Entities\ProductCategory;

class ProductCategoryCreateRepositoryMemory
{
    private $productCategorys;

    /**
     * @var Entities\ProductCategory
     */
    public function create(ProductCategory $productCategory)
    {
        $productCategory_array = [
            'id' => '1',
            'name' => $productCategory->name,
            'tax_id' => $productCategory->tax_id
        ];

        $this->productCategorys[] = $productCategory_array;
        return $productCategory_array;
    }
}
