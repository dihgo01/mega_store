<?php

use PHPUnit\Framework\TestCase;
use Repositories\Sales\Memory\SalesUpdateRepositoryMemory;
use Modules\Sales\UpdateSales\UpdateSalesCase;

class UpdateSalesTest extends TestCase
{
    private $salesUpdateRepository;
    private $updateSales;

    protected function setUp(): void
    {
        $this->salesUpdateRepository = new SalesUpdateRepositoryMemory();
        $this->updateSales = new UpdateSalesCase($this->salesUpdateRepository);
    }

    /** @test */
    public function should_be_able_to_update_a_sales(): void
    {
        $data = [
            "price" => 300.0,
            "status" => "Pago"
        ];

        $Sales = $this->updateSales->execute($data, '1', '2');

        $this->assertEquals($data, $Sales);
    }

    /** @test */
    public function should_be_able_to_not_update_if_it_not_find_sales(): void
    {
        $data = [
            "price" => 300.0,
            "status" => "Pago"
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Sales not found.');
        $this->updateSales->execute($data, '10', '2');
    }

}
