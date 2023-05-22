<?php

namespace Modules\Sales\UpdateSales;

use Exception;
use Modules\Sales\UpdateSales\UpdateSalesCase;

class SalesUpdateController
{
    private $updateSales;

    public function __construct(UpdateSalesCase $updateSales)
    {
        $this->updateSales = $updateSales;
    }

    public function handle(array $request)
    {
        try {
            $sales = $this->updateSales->execute($request['body'], $request['body']['id'], $request['user_id']);

            http_response_code(201);
            $response = [
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
