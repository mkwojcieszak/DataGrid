<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;
use \MKW\DataGridLib\Interfaces\Config;

class RawType implements DataType
{
    private $orderType = "Text";

    public function getOrderType(): string
    {
        return $this->orderType;
    }

    public function format(string $value): string
    {
        return $value;
    }
}