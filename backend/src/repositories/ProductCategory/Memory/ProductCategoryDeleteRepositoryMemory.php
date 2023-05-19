<?php

namespace Repositories\ProductCategory\Memory;


class ProductCategoryDeleteRepositoryMemory 
{
    protected $productCategorys = [];

    public function __construct()
    {
        $productCategory1 = [
            'id' => '1',
            'name' => 'IPTU',
            'percentage' => 10,
        ];

        $productCategory2 = [
            'id' => '2',
            'name' => 'IRR',
            'percentage' => 20,
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


    public function delete(string $id)
    {
        foreach ($this->productCategorys as $key => $item) {
            if ($item['id'] === $id) {
                $this->productCategorys[$key] = [];
                return true;
            }
        }
    }
 
}
