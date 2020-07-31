<?php

namespace MKW\DataGridLib\Interfaces;

interface DataType
{
    /**
     * Formatuje dane dla danego typu.
     */
    public function format(string $value): string;
}