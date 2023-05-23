<?php

namespace Modules\Sales\CreateSales;

use Entities\Sales;
use Entities\SalesProduct;
use Exception;

class CreateSalesCase
{
    private $salesRepository;

    public function __construct($salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    /**
     * @var array
     * @var string
     */
    public function execute(array $data, string $user_id)
    {
        $salesClass = new Sales($user_id, $data['price'], $data['status']);

        $sales_product = [];

        if(count($data['products']) < 1 || empty($data['products'])){
            throw new Exception('Error creating sale please add products to cart.');
        }

        foreach($data['products'] as $product) {
            $sales_product[] = new SalesProduct($product['product_id'],(float)$product['price'], $product['amount']);
        }

        $sales = $this->salesRepository->create($salesClass, $sales_product);

        return $sales;
    }
}
