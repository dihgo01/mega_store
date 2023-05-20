<?php

namespace Modules\Sales\DeleteSales;

use Exception;

class DeleteSalesCase
{
    private $salesRepository; 

    public function __construct($salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    /**
     * @var array
     */
    public function execute(string $id)
    {
        $salesExist = $this->salesRepository->findBySales($id);

        if (!$salesExist) {
            throw new Exception('Sales not found.');
        }
    
        $salesResponse = $this->salesRepository->delete($id);

        return $salesResponse;
    }
}
