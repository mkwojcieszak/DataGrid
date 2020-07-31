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
    
    public function setDateTimeFormat(string $val): DataType
    {
        $this->dateTimeFormat = $val;
        return $this;
    }

    public function format(string $value): string
    {
        $date = new \DateTime($value);
        $html = $date->format($this->dateTimeFormat);
        return $html;
    }
}