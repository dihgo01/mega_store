<?php

namespace Repositories\Tax\Memory;


class TaxDeleteRepositoryMemory
{
    protected $taxs = [];

    public function __construct()
    {
        $tax1 = [
            'id' => '1',
            'name' => 'IPTU',
            'percentage' => 10,
        ];

        $tax2 = [
            'id' => '2',
            'name' => 'IRR',
            'percentage' => 20,
        ];

        array_push($this->taxs, $tax1);
        array_push($this->taxs, $tax2);
    }

    /**
     * @var string
     */
    public function findByTax(string $id)
    {
        foreach ($this->taxs as $tax) {
            if ($tax['id'] === $id) {
                return (object)$tax;
            }
        }
        return false;
    }


    public function delete(string $id)
    {
        foreach ($this->taxs as $key => $item) {
            if ($item['id'] === $id) {
                $this->taxs[$key] = [];
                return true;
            }
        }
    }
 
}
