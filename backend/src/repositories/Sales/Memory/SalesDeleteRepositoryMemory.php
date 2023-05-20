<?php

namespace Repositories\Sales\Memory;


class SalesDeleteRepositoryMemory 
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


    public function delete(string $id)
    {
        foreach ($this->sales as $key => $item) {
            if ($item['id'] === $id) {
                $this->sales[$key] = [];
                return true;
            }
        }
    }
 
}
