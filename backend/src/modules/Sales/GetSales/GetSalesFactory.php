<?php

namespace Modules\Sales\GetSales;

use Modules\Sales\GetSales\GetSalesCase;
use Modules\Sales\GetSales\SalesGetController;
use Repositories\Sales\SalesGetRepository;

class GetSalesFactory {

    public function handle ($request) {
        $salesRepository = new SalesGetRepository();
        $getSales = new GetSalesCase($salesRepository);
        $salesGetController = new SalesGetController($getSales);
        return $salesGetController->handle($request);
    }
}