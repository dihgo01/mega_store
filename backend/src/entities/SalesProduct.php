<?php

namespace Entities;

class SalesProduct
{
    public $sales_id;
    public $product_id;
    public $amount;
    public $price;
    
    public function __construct(string $product_id, float $price, string $amount, string $sales_id = null)
    {
        $this->sales_id = $sales_id;
        $this->product_id = $product_id;
        $this->amount = $amount;
        $this->price = $price;      
    }
}
