<?php

use PHPUnit\Framework\TestCase;
use Repositories\Product\Memory\ProductDeleteRepositoryMemory;
use Modules\Product\DeleteProduct\DeleteProductCase;

class DeleteProductTest extends TestCase
{
    private $productDeleteRepository;
    private $deleteProduct;

    protected function setUp(): void
    {
        $this->productDeleteRepository = new ProductDeleteRepositoryMemory();
        $this->deleteProduct = new DeleteProductCase($this->productDeleteRepository);
    }

    /** @test */
    public function should_be_able_to_delete_a_product(): void
    {
        $product = $this->deleteProduct->execute('1');

        $this->assertTrue($product);
    }

    /** @test */
    public function should_be_able_to_not_delete_if_it_not_find_product_(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Product not found.');
        $this->deleteProduct->execute('10');
    }

}
