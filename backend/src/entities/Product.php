<?php

namespace Entities;

class Product
{
    public $name;
    public $price;
    public $category_id;

    public function __construct( string $name_product, float $price, string $category_id)
    {
        $this->name = $name_product;
        $this->price = $price;
        $this->category_id = $category_id;
    }
}
