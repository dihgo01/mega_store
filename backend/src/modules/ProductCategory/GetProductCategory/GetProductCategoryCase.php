<?php

namespace Modules\ProductCategory\GetProductCategory;

class GetProductCategoryCase
{
    private $productCategoryRepository;

    public function __construct($productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }


    public function execute()
    {

        $productCategory = $this->productCategoryRepository->list();

        return $productCategory;
    }
}
