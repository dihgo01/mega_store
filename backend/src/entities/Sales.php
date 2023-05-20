<?php

namespace Entities;

class Sales
{
    public $user_id;
    public $price;
    public $status;

    public function __construct(string $user_id, float $price, string $status)
    {
        $this->user_id = $user_id;
        $this->price = $price;
        $this->status = $status;
    }
}
