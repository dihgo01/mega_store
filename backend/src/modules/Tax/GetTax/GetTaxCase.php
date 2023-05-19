<?php

namespace Modules\Tax\GetTax;

class GetTaxCase
{
    private $taxRepository;

    public function __construct($taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }


    public function execute()
    {

        $tax = $this->taxRepository->list();

        return $tax;
    }
}
