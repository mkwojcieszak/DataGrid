<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\Column;
use \MKW\DataGridLib\Interfaces\DataType;

class TableColumn implements Column
{
    private $label;
    private $type;
    private $align;

    /**
     * Zmienia tytuł kolumny, który będzie widoczny jako nagłówek.
     */
    public function withLabel(string $label): Column
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Ustawia typ danych dla kolumny.
     */
    public function withDataType(DataType $type): Column
    {
        $this->type = $type;
        return $this;
    }

    public function getDataType(): DataType
    {
        return $this->type;
    }

    /**
     * Ustawienie wyrównania treści znajdujących się w kolumnie.
     */
    public function withAlign(string $align): Column
    {
        $this->align = $align;
        return $this;
    }

    public function getAlign(): string
    {
        return $this->align;
    }
}