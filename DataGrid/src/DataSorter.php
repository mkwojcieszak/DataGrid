<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\State;
use \MKW\DataGridLib\Interfaces\Column;

class DataSorter
{
    private $orderBy;

    public function getCurrentPageRows(array $rows, State $state): array
    {
        $page = $state->getCurrentPage();
        $pageSize = $state->getRowsPerPage();
        $cpr = array();
        $firstIndex = $pageSize * ($page - 1);

        for($i = 0; $i < $pageSize; $i++) {
            $ind = $firstIndex + $i;
            if ($ind < count($rows)) {
                $cpr[] = $rows[$ind];
            }
        }

        return $cpr;
    }

    public function sort(array $rows, State $state, array $columns): array
    {
        $order = $state->getOrder();
        $orderBy = $state->getOrderBy();
        $this->orderBy = $orderBy;
        
        if ($order != "none" && $orderBy != "none") {
            $validRows = $this->getValidRows($rows, $orderBy);
            $invalidRows = $this->getInvalidRows($rows, $orderBy);
            $sortedRows = $validRows;

            $sortingFunction = $this->getSortingFunction($order, $orderBy, $columns);
            usort($sortedRows, array("MKW\DataGridLib\DataSorter", $sortingFunction));

            foreach($invalidRows as $ivrow) {
                $sortedRows[] = $ivrow;
            }

            return $sortedRows;
        } else {
            return $rows;
        }
    }

    private function getValidRows(array $rows, string $orderBy): array
    {
        $validRows = array();
        foreach($rows as $row) {
            if (is_array($row)) {
                if (isset($row[$orderBy])) {
                    $validRows[] = $row;
                }
            }
        }

        return $validRows;
    }

    private function getInvalidRows(array $rows, string $orderBy): array
    {
        $invalidRows = array();
        foreach($rows as $row) {
            if (!is_array($row)) {
                $invalidRows[] = $row;
            } else if (!isset($row[$orderBy])) {
                $invalidRows[] = $row;
            }
        }

        return $invalidRows;
    }

    private function getSortingFunction(string $order, string $orderBy, array $columns):string
    {
        //
        $func = "compare";
        foreach($columns as $col) {
            $column = $col['column'];
            if ($column->getLabel() == $orderBy) {
                $func .= $column->getDataType()->getOrderType();
            }
        }
        if ($order == "asc")
            $func .= "Asc";
        else
            $func .= "Desc";
        return $func;
    }

    private function compareTextAsc($a, $b)
    {
        if (isset($a[$this->orderBy])) {
            $av = $a[$this->orderBy];
        } else {
            return -1;
        }

        if (isset($b[$this->orderBy])) {
            $bv = $b[$this->orderBy];
        } else {
            return 1;
        }

        if ($av == $bv) {
            return 0;
        }

        $arr = array($av, $bv);
        $arr2 = array($av, $bv);
        sort($arr2);
        return ($arr[0] == $arr2[0]) ? -1 : 1;
    }

    private function compareTextDesc($a, $b)
    {
        if (isset($a[$this->orderBy])) {
            $av = $a[$this->orderBy];
        } else {
            return -1;
        }

        if (isset($b[$this->orderBy])) {
            $bv = $b[$this->orderBy];
        } else {
            return 1;
        }

        if ($av == $bv) {
            return 0;
        }
        $arr = array($av, $bv);
        $arr2 = array($av, $bv);
        sort($arr2);
        return ($arr[0] == $arr2[0]) ? 1 : -1;
    }

    private function compareNumbersAsc($a, $b)
    {
        $av = $a[$this->orderBy];
        $bv = $b[$this->orderBy];

        if ($av == $bv) {
            return 0;
        }
        return ($av < $bv) ? -1 : 1;
    }

    private function compareNumbersDesc($a, $b)
    {
        $av = $a[$this->orderBy];
        $bv = $b[$this->orderBy];

        if ($av == $bv) {
            return 0;
        }
        return ($av > $bv) ? -1 : 1;
    }
}