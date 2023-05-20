<?php

use PHPUnit\Framework\TestCase;
use Repositories\Sales\Memory\SalesCreateRepositoryMemory;
use Modules\Sales\CreateSales\CreateSalesCase;

class CreateSalesTest extends TestCase
{
    private $salesCreateRepository;
    private $createSales;

    protected function setUp(): void
    {
        $this->salesCreateRepository = new SalesCreateRepositoryMemory();
        $this->createSales = new CreateSalesCase($this->salesCreateRepository);
    }

    /** @test */
    public function should_be_able_to_create_a_new_sales(): void
    {
        $data = [
            "price" => 200.0,
            "status" => "Pendente",
            "products" => [
                [
                    "product_id" => "1",
                    "price" => 100.0,
                    "amount" => 2
                ]
            ]
        ];

        $sales = $this->createSales->execute($data, "1");

        $this->assertSame('1', $sales['id']);
    }

    /** @test */
    public function should_be_able_to_not_create_a_session(): void
    {
        $data = [
            "price" => 200.0,
            "status" => "Pendente",
            "products" => []
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Error creating sale please add products to cart.');
        $this->createSales->execute($data, "1");
    }
}
