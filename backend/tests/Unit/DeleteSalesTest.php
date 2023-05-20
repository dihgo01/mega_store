<?php

use PHPUnit\Framework\TestCase;
use Repositories\Sales\Memory\SalesDeleteRepositoryMemory;
use Modules\Sales\DeleteSales\DeleteSalesCase;

class DeleteSalesTest extends TestCase
{
    private $salesDeleteRepository;
    private $deleteSales;

    protected function setUp(): void
    {
        $this->salesDeleteRepository = new SalesDeleteRepositoryMemory();
        $this->deleteSales = new DeleteSalesCase($this->salesDeleteRepository);
    }

    /** @test */
    public function should_be_able_to_delete_a_sales(): void
    {
        $Sales = $this->deleteSales->execute('1');

        $this->assertTrue($Sales);
    }

    /** @test */
    public function should_be_able_to_not_delete_if_it_not_find_sales(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Sales not found.');
        $this->deleteSales->execute('10');
    }

}
