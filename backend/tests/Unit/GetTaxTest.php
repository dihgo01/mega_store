<?php

use PHPUnit\Framework\TestCase;
use Repositories\Tax\Memory\TaxGetRepositoryMemory;
use Modules\Tax\GetTax\GetTaxCase;

class GetTaxTest extends TestCase
{
    private $taxRepository;
    private $getTax;

    protected function setUp(): void
    {
        $this->taxRepository = new TaxGetRepositoryMemory();
        $this->getTax = new GetTaxCase($this->taxRepository);
    }

    /** @test */
    public function should_be_able_to_list_tax(): void
    {
        $data = [
            [
                'name' => 'IPTU',
                'percentage' => 10
            ]
        ];

        $tax = $this->getTax->execute();

        $this->assertEquals($data, $tax);
    }
}
