<?php

use PHPUnit\Framework\TestCase;
use Repositories\Product\Memory\ProductCreateRepositoryMemory;
use Modules\Product\CreateProduct\CreateProductCase;

class CreateProductTest extends TestCase
{
    private $productCreateRepository;
    private $createProduct;

    protected function setUp(): void
    {
        $this->productCreateRepository = new ProductCreateRepositoryMemory();
        $this->createProduct = new CreateProductCase($this->productCreateRepository);
    }

    /** @test */
    public function should_be_able_to_create_a_new_product(): void
    {
        $data = [
            'name_product' => 'Tenis Testes',
            'price' => 100.0,
            'category_id' => 1
        ]; 

        $product = $this->createProduct->execute($data);

        $this->assertSame('1', $product['id']);
    }

}
