<?php

namespace Modules\ProductCategory\GetOnlyProductCategory;

class GetOnlyProductCategoryCase
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
