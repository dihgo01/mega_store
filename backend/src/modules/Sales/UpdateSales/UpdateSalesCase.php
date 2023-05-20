<?php

namespace Modules\Sales\UpdateSales;

use Entities\Sales;
use Exception;

class UpdateSalesCase
{
    private $salesRepository;

    public function __construct($salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    /**
     * @var array
     * @var string
     * @var string
     */
    public function execute(array $data, string $id, string $user_id)
    {
        $salesExist = $this->salesRepository->findBySales($id, $user_id);

        if (!$salesExist) {
            throw new Exception('Sales not found.');
        }

        $salesClass = new Sales($user_id, $data['price'], $data['status']);
    
        $SalesResponse = $this->salesRepository->update($salesClass, $id);

        return $SalesResponse;
    }
}
