<?php

namespace Modules\Sales\CreateSales;

use Exception;
use Modules\Sales\CreateSales\CreateSalesCase;

class SalesCreateController
{
    private $createSales;

    public function __construct(CreateSalesCase $createSales)
    {
        $this->createSales = $createSales;
    }

    public function handle($request)
    {
        try {
            $sales = $this->createSales->execute($request['body'], $request['user_id']);

            http_response_code(201);
            $response = [
                'message' => 'Venda cadastrada com sucesso!',
                'data' => $sales
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
