<?php

use PHPUnit\Framework\TestCase;
use Repositories\ProductCategory\Memory\ProductCategoryGetRepositoryMemory;
use Modules\ProductCategory\GetProductCategory\GetProductCategoryCase;

class GetOnlyProductCategoryTest extends TestCase
{
    private $ProductCategoryRepository;
    private $getProductCategory;

    protected function setUp(): void
    {
        $this->ProductCategoryRepository = new ProductCategoryGetRepositoryMemory();
        $this->getProductCategory = new GetProductCategoryCase($this->ProductCategoryRepository);
    }

    /** @test */
    public function should_be_able_to_list_product_category_only(): void
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Tenis Test',
                'tax' => 'IPTU',
            ]
        ];

        $ProductCategory = $this->getProductCategory->execute();

        $this->assertEquals($data, $ProductCategory);
    }
}
