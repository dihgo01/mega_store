<?php

use PHPUnit\Framework\TestCase;
use Repositories\ProductCategory\Memory\ProductCategoryDeleteRepositoryMemory;
use Modules\ProductCategory\DeleteProductCategory\DeleteProductCategoryCase;

class DeleteProductCategoryTest extends TestCase
{
    private $productCategoryDeleteRepository;
    private $deleteProductCategory;

    protected function setUp(): void
    {
        $this->productCategoryDeleteRepository = new ProductCategoryDeleteRepositoryMemory();
        $this->deleteProductCategory = new DeleteProductCategoryCase($this->productCategoryDeleteRepository);
    }

    /** @test */
    public function should_be_able_to_delete_a_product_category(): void
    {
        $productCategory = $this->deleteProductCategory->execute('1');

        $this->assertTrue($productCategory);
    }

    /** @test */
    public function should_be_able_to_not_delete_if_it_not_find_product_category(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Category not found.');
        $this->deleteProductCategory->execute('10');
    }

}
