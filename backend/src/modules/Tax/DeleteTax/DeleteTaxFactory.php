<?php

namespace Modules\Tax\DeleteTax;

use Modules\Tax\DeleteTax\DeleteTaxCase;
use Modules\Tax\DeleteTax\TaxDeleteController;
use Repositories\Tax\TaxDeleteRepository;

class DeleteTaxFactory {

    public function handle ($request) {
        $taxRepository = new TaxDeleteRepository();
        $deleteTax = new DeleteTaxCase($taxRepository);
        $taxDeleteController = new TaxDeleteController($deleteTax);
        return $taxDeleteController->handle($request);
    }
}