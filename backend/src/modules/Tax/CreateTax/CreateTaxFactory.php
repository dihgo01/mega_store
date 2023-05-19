<?php

namespace Modules\Tax\CreateTax;

use Modules\Tax\CreateTax\CreateTaxCase;
use Modules\Tax\CreateTax\TaxCreateController;
use Repositories\Tax\TaxCreateRepository;

class CreateTaxFactory {

    public function handle ($request) {
        $taxRepository = new TaxCreateRepository();
        $createTax = new CreateTaxCase($taxRepository);
        $taxCreateController = new TaxCreateController($createTax);
        return $taxCreateController->handle($request);
    }
}