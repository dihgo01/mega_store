<?php

namespace Repositories\Tax\Memory;

class TaxGetRepositoryMemory
{
    private $taxs = [];

    public function __construct()
    {
        $this->taxs[] = [
            'name' => 'IPTU',
            'percentage' => 10
        ];
    }

 
    public function list()
    {
        return $this->taxs;
    }
}
