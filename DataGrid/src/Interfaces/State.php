<?php

namespace MKW\DataGridLib\Interfaces;

interface State
{
    /**
     * Zwraca aktualna strone DataGrid do wyświetlenia
     */
    public function getCurrentPage(): int;

    /**
     * Klucz kolumny, po której będzie sortowany DataGrid.
     */
    public function getOrderBy(): string;

    /**
     * Czy dane mają zostać posortowane malejąco?
     */
    public function isOrderDesc(): bool;

    /**
     * Czy dane mają zostać posortowane rosnąco?
     */
    public function isOrderAsc(): bool;

    /**
     * Zwraca ilośc wierszy które mają zostać wyświetlone na jednej stronie.
     */
    public function getRowsPerPage(): int;
}