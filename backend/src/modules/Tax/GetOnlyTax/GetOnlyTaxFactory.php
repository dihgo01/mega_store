<?php

namespace Modules\Tax\GetOnlyTax;

use Modules\Tax\GetOnlyTax\GetOnlyTaxCase;
use Modules\Tax\GetOnlyTax\TaxGetOnlyController;
use Repositories\Tax\TaxGetOnlyRepository;

class GetOnlyTaxFactory {

    public function handle ($request) {
        $taxRepository = new TaxGetOnlyRepository();
        $getOnlyTax = new GetOnlyTaxCase($taxRepository);
        $taxGetOnlyController = new TaxGetOnlyController($getOnlyTax);
        return $taxGetOnlyController->handle($request);
    }
}