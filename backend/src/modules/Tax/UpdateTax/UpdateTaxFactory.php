<?php

namespace Modules\Tax\UpdateTax;

use Modules\Tax\UpdateTax\UpdateTaxCase;
use Modules\Tax\UpdateTax\TaxUpdateController;
use Repositories\Tax\TaxUpdateRepository;

class UpdateTaxFactory {

    public function handle ($request) {
        $taxRepository = new TaxUpdateRepository();
        $updateTax = new UpdateTaxCase($taxRepository);
        $taxUpdateController = new TaxUpdateController($updateTax);
        return $taxUpdateController->handle($request);
    }
}