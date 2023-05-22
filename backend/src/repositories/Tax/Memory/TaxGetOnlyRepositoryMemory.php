<?php

namespace Repositories\Tax\Memory;

class TaxGetOnlyRepositoryMemory
{
    private $taxs = [];

    public function __construct()
    {
        $this->taxs[] = [
            'name' => 'IPTU',
            'percentage' => 10
        ];
    }

 
    public function list(string $id)
    {
        return $this->taxs;
    }
}
