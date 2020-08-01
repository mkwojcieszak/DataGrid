<?php

namespace MKW\DataGridLib\Interfaces;

use \MKW\DataGridLib\Interfaces\DataType;

interface Column
{
    public function getLabel(): string;

    public function getDataType(): DataType;

    public function getAlign(): string;
}