<?php

namespace Modules\Tax\UpdateTax;

use Entities\Tax;
use Exception;

class UpdateTaxCase
{
    private $taxRepository;

    public function __construct($taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * @var array
     */
    public function execute(array $data, string $id)
    {
        $taxExist = $this->taxRepository->findByTax($id);

        if (!$taxExist) {
            throw new Exception('Tax not found.');
        }

        $taxClass = new Tax($data['name'], $data['percentage']);
    
        $taxResponse = $this->taxRepository->update($taxClass, $id);

        return $taxResponse;
    }
}
