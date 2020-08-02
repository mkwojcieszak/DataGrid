<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;
use \MKW\DataGridLib\Interfaces\Config;

class DateTimeType implements DataType
{
    private $orderType = "Text";
    private $dateTimeFormat = "Y-m-d";

    public function getOrderType(): string
    {
        return $this->orderType;
    }
    
    public function __construct(string $val)
    {
        $this->dateTimeFormat = $val;
    }

    public function format(string $value): string
    {
        $value = strip_tags($value);
        $date = new \DateTime($value);
        $html = $date->format($this->dateTimeFormat);
        return $html;
    }
}