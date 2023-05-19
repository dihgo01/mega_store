<?php

namespace Modules\Tax\CreateTax;

use Entities\Tax;

class CreateTaxCase
{
    private $taxRepository;

    public function __construct($taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data)
    {
        $taxClass = new Tax($data['name'], $data['percentage']);

        $tax = $this->taxRepository->create($taxClass);

        return $tax;
    }
}
