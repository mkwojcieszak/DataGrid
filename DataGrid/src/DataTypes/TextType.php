<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;

class TextType implements DataType
{
    private $orderType = "Text";

    public function getOrderType(): string
    {
        return $this->orderType;
    }

    public function format(string $value): string
    {
        $value = strip_tags($value);
        $value = str_replace(" ", "&nbsp", $value);
        return $value;
    }
}