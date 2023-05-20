<?php

namespace Repositories\Sales\Memory;

use Entities\Sales;

class SalesUpdateRepositoryMemory
{
    protected $sales = [];

    public function __construct()
    {
        $sales1 = [
            'id' => '1',
            'user_id' => '2',
            'price' => 'R$ 100,00',
            'status' => 'Pendente',
        ];

        $sales2 = [
            'id' => '2',
            'user_id' => '2',
            'price' => 'R$ 150,00',
            'status' => 'Pago',
        ];

        array_push($this->sales, $sales1);
        array_push($this->sales, $sales2);
    }

    /**
     * @var string
     */
    public function findBySales(string $id)
    {
        foreach ($this->sales as $sales) {
            if ($sales['id'] === $id) {
                return (object)$sales;
            }
        }
        return false;
    }

    /**
     * @var Entities\Sales
     */
    public function update(Sales $sales, string $id)
    {
        foreach ($this->sales as $key => $item) {
            if ($item['id'] === $id) {
                $salesUpdate = [
                    'id' => '1',
                    'user_id' => $sales->user_id,
                    'price' => $sales->price,
                    'status' => $sales->status
                ];

                $this->sales[$key] = $salesUpdate;
                unset($salesUpdate['id']);
                unset($salesUpdate['user_id']);
                return $salesUpdate;
            }
        }
    }
}
