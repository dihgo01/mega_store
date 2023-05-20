<?php

namespace Modules\Sales\UpdateSales;

use Modules\Sales\UpdateSales\UpdateSalesCase;
use Modules\Sales\UpdateSales\SalesUpdateController;
use Repositories\Sales\SalesUpdateRepository;

class UpdateSalesFactory {

    public function handle ($request) {
        $salesRepository = new SalesUpdateRepository();
        $updateSales = new UpdateSalesCase($salesRepository);
        $salesUpdateController = new SalesUpdateController($updateSales);
        return $salesUpdateController->handle($request);
    }
}