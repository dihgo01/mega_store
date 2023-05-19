<?php

namespace Repositories\ProductCategory\Memory;

class ProductCategoryGetRepositoryMemory
{
    private $productCategorys = [];

    public function __construct()
    {
        $this->productCategorys[] = [
            'id' => '1',
            'name' => 'Tenis Test',
            'tax' => 'IPTU'
        ];
    }

 
    public function list()
    {
        return $this->productCategorys;
    }
}
