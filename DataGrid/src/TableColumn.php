<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\Column;
use \MKW\DataGridLib\Interfaces\DataType;

class TableColumn implements Column
{
    private $label;
    private $type;
    private $align;

    public function __construct(string $label, DataType $type, string $align)
    {
        $this->label = $label;
        $this->type = $type;
        $this->align = $align;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDataType(): DataType
    {
        return $this->type;
    }

    public function getAlign(): string
    {
        return $this->align;
    }
}