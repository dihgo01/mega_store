<?php

namespace Repositories\Sales\Memory;

class SalesGetRepositoryMemory
{
    private $sales = [];

    public function __construct()
    {
        $this->sales[] = [
            'id' => '1',
            'user_id' => '2',
            'price' => 'R$ 100,00',
            'status' => 'Pendente',
        ];
    }

    public function list()
    {
        return $this->sales;
    }
}
