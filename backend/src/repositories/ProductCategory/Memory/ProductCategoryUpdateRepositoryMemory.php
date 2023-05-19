<?php

namespace Repositories\ProductCategory\Memory;

use Entities\ProductCategory;

class ProductCategoryUpdateRepositoryMemory
{
    protected $productCategorys = [];

    public function __construct()
    {
        $productCategory1 = [
            'id' => '1',
            'name' => 'Tenis 1',
            'tax_id' => '10',
        ];

        $productCategory2 = [
            'id' => '2',
            'name' => 'Tenis 2',
            'tax_id' => '20',
        ];

        array_push($this->productCategorys, $productCategory1);
        array_push($this->productCategorys, $productCategory2);
    }

    /**
     * @var string
     */
    public function findByProductCategory(string $id)
    {
        foreach ($this->productCategorys as $productCategory) {
            if ($productCategory['id'] === $id) {
                return (object)$productCategory;
            }
        }
        return false;
    }

    /**
     * @var Entities\ProductCategory
     */
    public function update(ProductCategory $productCategory, string $id)
    {
        foreach ($this->productCategorys as $key => $item) {
            if ($item['id'] === $id) {
                $productCategoryUpdate = [
                    'id' => '1',
                    'name' => $productCategory->name,
                    'tax_id' => $productCategory->tax_id
                ];

                $this->productCategorys[$key] = $productCategoryUpdate;
                unset($productCategoryUpdate['id']);
                return $productCategoryUpdate;
            }
        }
    }
}
