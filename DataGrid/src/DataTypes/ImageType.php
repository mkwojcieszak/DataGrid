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
    
    public function __construct(int $height, int $width)
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function format(string $value): string
    {
        $notags = strip_tags($value);
        $newtags = "<img width=".$this->width." height=".$this->height." src='".$notags."'></img>";
        return $newtags;
    }
}