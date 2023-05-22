<?php

namespace Modules\Tax\GetTax;

use Exception;
use Modules\Tax\GetTax\GetTaxCase;

class TaxGetController
{
    private $getTax;

    public function __construct(GetTaxCase $getTax)
    {
        $this->getTax = $getTax;
    }

    public function handle($request)
    {
        try {
            $tax = $this->getTax->execute();

            http_response_code(201);
            $response = $tax;

            echo json_encode($response);
        } catch (Exception $e) {

            http_response_code(401);
            $response = [
                'message' => $e->getMessage(),
            ];

            echo json_encode($response);
        }
    }
}
