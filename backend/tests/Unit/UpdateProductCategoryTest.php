<?php

use PHPUnit\Framework\TestCase;
use Repositories\ProductCategory\Memory\ProductCategoryUpdateRepositoryMemory;
use Modules\ProductCategory\UpdateProductCategory\UpdateProductCategoryCase;

class UpdateProductCategoryTest extends TestCase
{
    private $productCategoryUpdateRepository;
    private $updateProductCategory;

    protected function setUp(): void
    {
        $this->productCategoryUpdateRepository = new ProductCategoryUpdateRepositoryMemory();
        $this->updateProductCategory = new UpdateProductCategoryCase($this->productCategoryUpdateRepository);
    }

    /** @test */
    public function should_be_able_to_update_a_product_category(): void
    {
        $data = [
            'name' => 'Tenis Test',
            'tax_id' => '11',
        ];

        $productCategory = $this->updateProductCategory->execute($data, '1');

        $this->assertEquals($data, $productCategory);
    }

    /** @test */
    public function should_be_able_to_not_update_if_it_not_find_product_category(): void
    {
        $data = [
            'name' => 'Tenis Test',
            'tax_id' => '10',
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Category not found.');
        $this->updateProductCategory->execute($data, '10');
    }

}
