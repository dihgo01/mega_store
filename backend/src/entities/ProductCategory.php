<?php

namespace Entities;

class ProductCategory
{
    public $name;
    public $tax_id;

    public function __construct( string $name, string $tax_id)
    {
        $this->name = $name;
        $this->tax_id = $tax_id;
    }
}
