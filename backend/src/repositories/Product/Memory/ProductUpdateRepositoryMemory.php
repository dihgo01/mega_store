<?php

namespace Repositories\Product\Memory;

use Entities\Product;

class ProductUpdateRepositoryMemory
{
    protected $products = [];

    public function __construct()
    {
        $product1 = [
            'id' => '1',
            'name_product' => 'Tenis 1',
            'price' => 100,
            'category_id' => '10',
        ];

        $product2 = [
            'id' => '2',
            'name_product' => 'Tenis 2',
            'price' => 150,
            'category_id' => '11',
        ];

        array_push($this->products, $product1);
        array_push($this->products, $product2);
    }

    /**
     * @var string
     */
    public function findByProduct(string $id)
    {
        foreach ($this->products as $product) {
            if ($product['id'] === $id) {
                return (object)$product;
            }
        }
        return false;
    }

    /**
     * @var Entities\Product
     */
    public function update(Product $product, string $id)
    {
        foreach ($this->products as $key => $item) {
            if ($item['id'] === $id) {
                $productUpdate = [
                    'id' => '1',
                    'name_product' => $product->name,
                    'price' => $product->price,
                    'category_id' => $product->category_id
                ];

                $this->products[$key] = $productUpdate;
                unset($productUpdate['id']);
                return $productUpdate;
            }
        }
    }
}
