<?php

use PHPUnit\Framework\TestCase;
use Repositories\Tax\Memory\TaxCreateRepositoryMemory;
use Modules\Tax\CreateTax\CreateTaxCase;

class CreateTaxTest extends TestCase
{
    private $taxCreateRepository;
    private $createTax;

    protected function setUp(): void
    {
        $this->taxCreateRepository = new TaxCreateRepositoryMemory();
        $this->createTax = new CreateTaxCase($this->taxCreateRepository);
    }

    /** @test */
    public function should_be_able_to_create_a_new_tax(): void
    {
        $data = [
            'name' => 'IPTU',
            'percentage' => 10
        ]; 

        $tax = $this->createTax->execute($data);

        $this->assertSame('1', $tax['id']);
    }

}
