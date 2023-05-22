<?php

namespace Modules\Tax\UpdateTax;

use Exception;
use Modules\Tax\UpdateTax\UpdateTaxCase;

class TaxUpdateController
{
    private $updateTax;

    public function __construct(UpdateTaxCase $updateTax)
    {
        $this->updateTax = $updateTax;
    }

    public function handle(array $request)
    {
        try {
            $tax = $this->updateTax->execute($request['body'], $request['body']['id']);

            http_response_code(201);
            $response = [
                'message' => 'Imposto atualizado com sucesso!',
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
