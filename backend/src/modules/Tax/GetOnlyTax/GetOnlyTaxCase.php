<?php

namespace Modules\Tax\GetOnlyTax;

class GetOnlyTaxCase
{
    private $taxRepository;

    public function __construct($taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }


    public function execute(string $id)
    {

        $tax = $this->taxRepository->list($id);

        return $tax;
    }
}
