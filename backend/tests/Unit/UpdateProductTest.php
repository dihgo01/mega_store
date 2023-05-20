<?php

use PHPUnit\Framework\TestCase;
use Repositories\Product\Memory\ProductUpdateRepositoryMemory;
use Modules\Product\UpdateProduct\UpdateProductCase;

class UpdateProductTest extends TestCase
{
    private $productUpdateRepository;
    private $updateProduct;

    protected function setUp(): void
    {
        $this->productUpdateRepository = new ProductUpdateRepositoryMemory();
        $this->updateProduct = new UpdateProductCase($this->productUpdateRepository);
    }

    /** @test */
    public function should_be_able_to_update_a_product(): void
    {
        $data = [
            'name_product' => 'Tenis Test',
            'price' => 300.0,
            'category_id' => '11',
        ];

        $product = $this->updateProduct->execute($data, '1');

        $this->assertEquals($data, $product);
    }

    /** @test */
    public function should_be_able_to_not_update_if_it_not_find_product(): void
    {
        $data = [
            'name_product' => 'Tenis Test',
            'price' => 300.0,
            'category_id' => '11',
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Product not found.');
        $this->updateProduct->execute($data, '10');
    }

}
