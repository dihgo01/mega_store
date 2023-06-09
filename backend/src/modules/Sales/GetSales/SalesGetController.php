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
            $total = count($sales);

            $response['result'] = true;
            $response['daw'] = (int)$total;
            $response["recordsTotal"] = (int)$total;
            $response["recordsFiltered"] = (int)$total;
            $response['data'] = $sales;
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
