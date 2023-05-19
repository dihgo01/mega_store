<?php

namespace Repositories\Tax\Memory;

use Entities\Tax;

class TaxCreateRepositoryMemory
{
    private $taxs;

    /**
     * @var Entities\Tax
     */
    public function create(Tax $tax)
    {
        $tax_array = [
            'id' => '1',
            'name' => $tax->name,
            'percentage' => $tax->percentage
        ];

        $this->taxs[] = $tax_array;
        return $tax_array;
    }
}
