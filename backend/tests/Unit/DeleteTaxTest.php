<?php

use PHPUnit\Framework\TestCase;
use Repositories\Tax\Memory\TaxDeleteRepositoryMemory;
use Modules\Tax\DeleteTax\DeleteTaxCase;

class DeleteTaxTest extends TestCase
{
    private $taxDeleteRepository;
    private $deleteTax;

    protected function setUp(): void
    {
        $this->taxDeleteRepository = new TaxDeleteRepositoryMemory();
        $this->deleteTax = new DeleteTaxCase($this->taxDeleteRepository);
    }

    /** @test */
    public function should_be_able_to_delete_a_tax(): void
    {
        $tax = $this->deleteTax->execute('1');

        $this->assertTrue($tax);
    }

    /** @test */
    public function should_be_able_to_not_delete_if_it_not_find_tax(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Tax not found.');
        $this->deleteTax->execute('10');
    }

}
