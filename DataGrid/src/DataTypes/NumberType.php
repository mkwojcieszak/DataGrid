<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;

class NumberType implements DataType
{
    private $orderType = "Numbers";

    public function getOrderType(): string
    {
        return $this->orderType;
    }

    public function format(string $value): string
    {
        return $value;
    }
}