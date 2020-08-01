<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;
use \MKW\DataGridLib\Interfaces\Config;

class DateType implements DataType
{
    private $orderType = "Text";
    private $dateFormat = "Y-m-d";

    public function getOrderType(): string
    {
        return $this->orderType;
    }
    
    public function __construct(string $val)
    {
        $this->dateFormat = $val;
    }

    public function format(string $value): string
    {
        $date = new \DateTime($value);
        $html = $date->format($this->dateFormat);
        return $html;
    }
}