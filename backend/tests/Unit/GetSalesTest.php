<?php

use PHPUnit\Framework\TestCase;
use Repositories\Sales\Memory\SalesGetRepositoryMemory;
use Modules\Sales\GetSales\GetSalesCase;

class GetSalesTest extends TestCase
{
    private $salesRepository;
    private $getSales;

    protected function setUp(): void
    {
        $this->salesRepository = new SalesGetRepositoryMemory();
        $this->getSales = new GetSalesCase($this->salesRepository);
    }

    /** @test */
    public function should_be_able_to_list_sales(): void
    {
        $data = [
            [
                'id' => '1',
                'user_id' => '2',
                'price' => 'R$ 100,00',
                'status' => 'Pendente',
            ]
        ];

        $sales = $this->getSales->execute('2');

        $this->assertEquals($data, $sales);
    }
}
