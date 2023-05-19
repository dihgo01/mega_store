<?php

use PHPUnit\Framework\TestCase;
use Repositories\Tax\Memory\TaxUpdateRepositoryMemory;
use Modules\Tax\UpdateTax\UpdateTaxCase;

class UpdateTaxTest extends TestCase
{
    private $taxUpdateRepository;
    private $updateTax;

    protected function setUp(): void
    {
        $this->taxUpdateRepository = new TaxUpdateRepositoryMemory();
        $this->updateTax = new UpdateTaxCase($this->taxUpdateRepository);
    }

    /** @test */
    public function should_be_able_to_update_a_tax(): void
    {
        $data = [
            'name' => 'IPTU',
            'percentage' => 10,
        ];

        $tax = $this->updateTax->execute($data, '1');

        $this->assertEquals($data, $tax);
    }

    /** @test */
    public function should_be_able_to_not_update_if_it_not_find_tax(): void
    {
        $data = [
            'name' => 'IPTU',
            'percentage' => 10,
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Tax not found.');
        $this->updateTax->execute($data, '10');
    }

}
