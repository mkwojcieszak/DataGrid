<?php

namespace MKW\DataGridLib\Interfaces;

use \MKW\DataGridLib\Interfaces\DataType;

interface Column
{
    /**
     * Zmienia tytuł kolumny, który będzie widoczny jako nagłówek.
     */
    public function withLabel(string $label): Column;

    public function getLabel(): string;

    /**
     * Ustawia typ danych dla kolumny.
     */
    public function withDataType(DataType $type): Column;

    public function getDataType(): DataType;

    /**
     * Ustawienie wyrównania treści znajdujących się w kolumnie.
     */
    public function withAlign(string $align): Column;

    public function getAlign(): string;
}