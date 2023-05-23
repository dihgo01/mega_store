<?php

namespace Modules\Sales\GetSales;

use Exception;
use Modules\Sales\GetSales\GetSalesCase;

class SalesGetController
{
    private $getSales;

    public function __construct(GetSalesCase $getSales)
    {
        $this->getSales = $getSales;
    }

    /**
     * @var array
     */
    public function handle(array $request)
    {
        try {
            $sales = $this->getSales->execute($request['user_id']);

            http_response_code(201);
            $response = $sales;

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
