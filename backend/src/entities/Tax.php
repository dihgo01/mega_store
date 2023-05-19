<?php

namespace Entities;

class Tax
{
    private $id;
    public $name;
    public $percentage;

    public function __construct(string $name, int $percentage, string $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->percentage = $percentage;
    }

}
