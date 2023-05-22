<?php

namespace Modules\Tax\CreateTax;

use Exception;
use Modules\Tax\CreateTax\CreateTaxCase;

class TaxCreateController
{
    private $createTax;

    public function __construct(CreateTaxCase $createTax)
    {
        $this->createTax = $createTax;
    }

    public function handle($request)
    {
        try {
            $tax = $this->createTax->execute($request['body']);

            http_response_code(201);
            $response = [
                'message' => 'Imposto cadastro com sucesso!',
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
