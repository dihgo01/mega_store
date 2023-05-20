<?php

namespace Repositories\Sales\Memory;

use Entities\Sales;

class SalesCreateRepositoryMemory
{
    private $sales;
    private $sales_product;

    /**
     * @var Entities\Sales
     */
    public function create(Sales $sales, array $products)
    {
        $id_sales = "1";

        $sales_array = [
            'id' => $id_sales,
            'user_id' => $sales->user_id,
            'price' => $sales->price,
            'status' => $sales->status,
        ];

        foreach ($products as $product) {
            $data_product = [
                'id' => "1",
                'sales_id' => $id_sales,
                'product_id' => $product->product_id,
                'amount' => $product->amount,
                'price' => $product->price
            ];

            $this->sales_product[] = $data_product;
        }

        $this->sales[] = $sales_array;
        $this->sales['products'] = $this->sales_product;
        
        return $sales_array;
    }
}
