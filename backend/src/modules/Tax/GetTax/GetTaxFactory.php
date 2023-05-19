<?php

namespace Modules\Tax\GetTax;

use Modules\Tax\GetTax\GetTaxCase;
use Modules\Tax\GetTax\TaxGetController;
use Repositories\Tax\TaxGetRepository;

class GetTaxFactory {

    public function handle ($request) {
        $taxRepository = new TaxGetRepository();
        $getTax = new GetTaxCase($taxRepository);
        $taxGetController = new TaxGetController($getTax);
        return $taxGetController->handle($request);
    }
}