<?php

namespace Modules\Sales\CreateSales;

use Modules\Sales\CreateSales\CreateSalesCase;
use Modules\Sales\CreateSales\SalesCreateController;
use Repositories\Sales\SalesCreateRepository;

class CreateSalesFactory {

    public function handle ($request) {
        $salesRepository = new SalesCreateRepository();
        $createSales = new CreateSalesCase($salesRepository);
        $salesCreateController = new SalesCreateController($createSales);
        return $salesCreateController->handle($request);
    }
}