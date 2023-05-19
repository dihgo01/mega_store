<?php

namespace Modules\Tax\DeleteTax;

use Exception;

class DeleteTaxCase
{
    private $taxRepository;

    public function __construct($taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * @var array
     */
    public function execute(string $id)
    {
        $taxExist = $this->taxRepository->findByTax($id);

        if (!$taxExist) {
            throw new Exception('Tax not found.');
        }
    
        $taxResponse = $this->taxRepository->delete($id);

        return $taxResponse;
    }
}
