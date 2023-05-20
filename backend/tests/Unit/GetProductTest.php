<?php

use PHPUnit\Framework\TestCase;
use Repositories\Product\Memory\ProductGetRepositoryMemory;
use Modules\Product\GetProduct\GetProductCase;

class GetProductTest extends TestCase
{
    private $ProductRepository;
    private $getProduct;

    protected function setUp(): void
    {
        $this->ProductRepository = new ProductGetRepositoryMemory();
        $this->getProduct = new GetProductCase($this->ProductRepository);
    }

    /** @test */
    public function should_be_able_to_list_product(): void
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Tenis Test',
                'price' => 100.0,
                'category_id' => 1,
            ]
        ];

        $Product = $this->getProduct->execute();

        $this->assertEquals($data, $Product);
    }
}
