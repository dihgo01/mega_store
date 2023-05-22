<?php

namespace Modules\Tax\GetOnlyTax;

use Exception;
use Modules\Tax\GetOnlyTax\GetOnlyTaxCase;

class TaxGetOnlyController
{
    private $getOnlyTax;

    public function __construct(GetOnlyTaxCase $getOnlyTax)
    {
        $this->getOnlyTax = $getOnlyTax;
    }

    public function handle(array $request)
    {
        try {
            $tax = $this->getOnlyTax->execute($request['body']['id']);

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
