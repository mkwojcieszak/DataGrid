<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\State;
use \MKW\DataGridLib\Interfaces\Config;
use \MKW\DataGridLib\Interfaces\Column;

class TableRenderer
{
    public function renderTable(array $rows, State $state, Config $config): string
    {
        $sorter = new DataSorter();
        $sortedRows = $sorter->sort($rows, $state, $config->getColumns());
        $currentPageRows = $sorter->getCurrentPageRows($sortedRows, $state);

        $tableTop = $this->getTableTop();
        $thead = $this->getTableHead($state, $config);
        $tableMiddle = $this->getTableMiddle();
        $tbody = $this->getTableBody($currentPageRows, $config);
        $tableBottom = $this->getTableBottom();
        
        return $tableTop.$thead.$tableMiddle.$tbody.$tableBottom;
    }

    private function getErrorHtml(): string
    {
        return '<svg class="bi bi-exclamation-triangle-fill" width="1em" height="1em"
        viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165
        13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982
        1.566zM8 5a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905
        0 0 0 8 5zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
        </svg>';
    }

    private function getTableTop(): string
    {
        return "<table class='table table-bordered'><thead><tr>";
    }

    private function getTableMiddle(): string
    {
        return "</tr></thead><tbody>";
    }

    private function getTableBottom(): string
    {
        return "</tbody></table>";
    }

    private function getTableHead(State $state, Config $config): string
    {
        $html = "<tr>";
        foreach($config->getColumns() as $col) {
            $column = $col['column'];
            $html .= $this->getColumnLabelHtml($state, $column);
        }
        $html .= "</tr>";
        return $html;
    }

    private function getColumnLabelHtml(State $state, Column $column): string
    {
        $html = "<td>";
        $arrow = "";
        $label = $column->getLabel();
        $order = $state->getOrder();
        $orderBy = $state->getOrderBy();
        $currentPage = $state->getCurrentPage();

        if ($orderBy == $label) {
            if ($order == "asc") {
                $order = "desc";
                $arrow = '<svg class="bi bi-arrow-down-short" width="1em" height="1em" viewBox="0 0 16 16"
                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.646 7.646a.5.5 0 0 1 .708 0L8 10.293l2.646-2.647a.5.5 0 0 1
                .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"></path>
                <path fill-rule="evenodd" d="M8 4.5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5z"></path>
            </svg>';
            } else if ($order == "desc") {
                $order = "none";
                $arrow = '<svg class="bi bi-arrow-up-short" width="1em" height="1em" viewBox="0 0 16 16"
                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"></path>
                <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8
                5.707 5.354 8.354a.5.5 0 1 1-.708-.708l3-3z"></path>
            </svg>';
            } else {
                $order = "asc";
                $arrow = '';
            }
        } else {
            $order = "asc";
        }
        $link = "index.php?order=$order&orderBy=$label&page=$currentPage";

        $html .= "<a href='".$link."'><b>".$label."</b></a>".$arrow;
        $html .= "</td>";
        return $html;
    }

    private function getTableBody(array $currentPageRows, Config $config): string
    {
        $html = "";
        foreach($currentPageRows as $row) {
            $html .= $this->getRowHtml($row, $config);
        }
        return $html;
    }

    private function getRowHtml($row, Config $config): string
    {
        $html = "<tr>";
        if (is_array($row)) {
            foreach($config->getColumns() as $col) {
                $html .= $this->getCellHtml($row, $col);
            }
        } else {
            $icontxt = $this->getErrorHtml();
            $html .= "<td colspan='100%' class='text-danger'>".$icontxt
            ." Błąd wiersza - w tym wierszu znajdują się błędne dane</td>";
        }
        $html .= "</tr>";

        return $html;
    }

    private function getCellHtml(array $row, array $column): string
    {
        $html = "";
        $col = $column['column'];
        $align = $col->getAlign();
        if (isset($row[$col->getLabel()])) {
            $val = $row[$col->getLabel()];
            $dataType = $col->getDataType();
            $formattedVal = $dataType->format($val);
            $html = "<td style='text-align: $align'>$formattedVal</td>";
        } else {
            $html .= '<td style="text-align: '.$align.'">'.$this->getErrorHtml().'</td>';
        }
        return $html;
    }
}