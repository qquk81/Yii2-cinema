<?php

namespace cinema\entities\Order;

class CustomerData
{
    public $phone;
    public $name;

    public function __construct($phone, $name)
    {
        $this->phone = $phone;
        $this->name = $name;
    }
}