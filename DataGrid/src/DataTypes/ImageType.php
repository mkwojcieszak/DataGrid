<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;
use \MKW\DataGridLib\Interfaces\Config;

class ImageType implements DataType
{
    private $orderType = "Text";
    private $width = 16;
    private $height = 16;

    public function getOrderType(): string
    {
        return $this->orderType;
    }
    
    public function setHeight(int $val): DataType
    {
        $this->height = $val;
        return $this;
    }

    public function setWidth(int $val): DataType
    {
        $this->width = $val;
        return $this;
    }

    public function format(string $value): string
    {
        $notags = strip_tags($value);
        $newtags = "<img width=".$this->width." height=".$this->height." src='".$notags."'></img>";
        return $newtags;
    }
}