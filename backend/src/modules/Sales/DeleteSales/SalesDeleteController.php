<?php

namespace Modules\Sales\DeleteSales;

use Exception;
use Modules\Sales\DeleteSales\DeleteSalesCase;

class SalesDeleteController
{
    private $deleteSales;

    public function __construct(DeleteSalesCase $deleteSales)
    {
        $this->deleteSales = $deleteSales;
    }

    public function handle(array $request)
    {
        try {
            $sales = $this->deleteSales->execute($request['body']['id']);

            http_response_code(201);
            $response = [
                'message' => 'Successfully deleted Sales!',
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
