<?php

namespace Repositories\Tax\Memory;

use Entities\Tax;

class TaxUpdateRepositoryMemory
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

    /**
     * @var Entities\Tax
     */
    public function update(Tax $tax, string $id)
    {
        foreach ($this->taxs as $key => $item) {
            if ($item['id'] === $id) {
                $taxUpdate = [
                    'id' => '1',
                    'name' => $tax->name,
                    'percentage' => $tax->percentage
                ];

                $this->taxs[$key] = $taxUpdate;
                unset($taxUpdate['id']);
                return $taxUpdate;
            }
        }
    }
}
