<?php

namespace Modules\Sales\GetSales;

class GetSalesCase
{
    private $salesRepository;

    public function __construct($salesRepository)
    { 
        $this->salesRepository = $salesRepository;
    }

    /**
     * @var string
     */
    public function execute(string $id)
    {
        $sales = $this->salesRepository->list($id);

        return $sales;
    }
}
