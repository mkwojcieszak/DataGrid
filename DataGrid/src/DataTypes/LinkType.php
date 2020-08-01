<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;
use \MKW\DataGridLib\Interfaces\Config;

class LinkType implements DataType
{
    private $orderType = "Text";
    private $tag = "a";
    private $class = "";

    public function getOrderType(): string
    {
        return $this->orderType;
    }
    
    public function __construct(string $tag, string $class)
    {
        $this->tag = $tag;
        $this->class = $class;
    }

    public function format(string $value): string
    {
        $val = strip_tags($value);
        $start = "<a href='".$val."'>";
        $end = "</a>";
        $class = $this->class;

        if ($this->tag == "a") {
            $html = "<a class='text-$class' href='$val'>$val</a>";
        } else if ($this->tag == "button") {
            $html = "<a href='$val'><button class='btn btn-$class'>$val</button></a>";
        } else {
            "Niepoprawny tag linku :".$this->tag;
        }
        return $html;
    }
}