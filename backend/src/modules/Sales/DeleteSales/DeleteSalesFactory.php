<?php

namespace Modules\Sales\DeleteSales;

use Modules\Sales\DeleteSales\DeleteSalesCase;
use Modules\Sales\DeleteSales\SalesDeleteController;
use Repositories\Sales\SalesDeleteRepository;

class DeleteSalesFactory {

    public function handle ($request) {
        $salesRepository = new SalesDeleteRepository();
        $deleteSales = new DeleteSalesCase($salesRepository);
        $salesDeleteController = new SalesDeleteController($deleteSales);
        return $salesDeleteController->handle($request);
    }
}