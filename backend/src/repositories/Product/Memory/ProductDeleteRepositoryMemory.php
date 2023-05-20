<?php

namespace Repositories\Product\Memory;


class ProductDeleteRepositoryMemory 
{
    protected $products = [];

    public function __construct()
    {
        $product1 = [
            'id' => '1',
            'name_product' => 'Tenis 1',
            'price' => 100,
            '_id' => '10',
        ];

        $product2 = [
            'id' => '2',
            'name_product' => 'Tenis 2',
            'price' => 150,
            '_id' => '11',
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


    public function delete(string $id)
    {
        foreach ($this->products as $key => $item) {
            if ($item['id'] === $id) {
                $this->products[$key] = [];
                return true;
            }
        }
    }
 
}
