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
    
    public function withConfig(Config $config): DataType
    {
        return $this;
    }

    public function format(string $value): string
    {
        $notags = strip_tags($value);
        $hardspace = str_replace(" ", "&nbsp", $notags);
        return $hardspace;
    }
}