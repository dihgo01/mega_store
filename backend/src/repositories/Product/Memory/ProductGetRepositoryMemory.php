<?php

namespace Repositories\Product\Memory;

class ProductGetRepositoryMemory
{
    private $products = [];

    public function __construct()
    {
        $this->products[] = [
            'id' => '1',
            'name' => 'Tenis Test',
            'price' => 100.0,
            'category_id' => 1,
        ];
    }

 
    public function list()
    {
        return $this->products;
    }
}
