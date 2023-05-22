<?php

namespace Modules\Tax\DeleteTax;

use Exception;
use Modules\Tax\DeleteTax\DeleteTaxCase;

class TaxDeleteController
{
    private $deleteTax;

    public function __construct(DeleteTaxCase $deleteTax)
    {
        $this->deleteTax = $deleteTax;
    }

    public function handle(array $request)
    {
        try {
            $tax = $this->deleteTax->execute($request['body']['id']);

            http_response_code(201);
            $response = [
                'message' => 'Successfully deleted tax!',
                'data' => $tax
            ];

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
