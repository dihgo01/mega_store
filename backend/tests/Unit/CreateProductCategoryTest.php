<?php

use PHPUnit\Framework\TestCase;
use Repositories\ProductCategory\Memory\ProductCategoryCreateRepositoryMemory;
use Modules\ProductCategory\CreateProductCategory\CreateProductCategoryCase;

class CreateProductCategoryTest extends TestCase
{
    private $productCategoryCreateRepository;
    private $createProductCategory;

    protected function setUp(): void
    {
        $this->productCategoryCreateRepository = new ProductCategoryCreateRepositoryMemory();
        $this->createProductCategory = new CreateProductCategoryCase($this->productCategoryCreateRepository);
    }

    /** @test */
    public function should_be_able_to_create_a_new_product_category(): void
    {
        $data = [
            'name' => 'Tenis',
            'tax_id' => "IDTAX"
        ]; 

        $productCategory = $this->createProductCategory->execute($data);

        $this->assertSame('1', $productCategory['id']);
    }

}
