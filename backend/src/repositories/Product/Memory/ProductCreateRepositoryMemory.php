<?php

namespace Repositories\Product\Memory;

use Entities\Product;

class ProductCreateRepositoryMemory
{
    private $products;

    /**
     * @var Entities\Product
     */
    public function create(Product $product)
    {
        $product_array = [
            'id' => '1',
            'name_product' => $product->name,
            'price' => $product->price,
            'category_id' => $product->category_id
        ];

        $this->products[] = $product_array;
        return $product_array;
    }
}
