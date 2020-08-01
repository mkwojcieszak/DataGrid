<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\DataGrid;
use \MKW\DataGridLib\Interfaces\Config;
use \MKW\DataGridLib\Interfaces\State;
use \MKW\DataGridLib\Interfaces\Column;

use \MKW\DataGridLib\DefaultConfig;
use \MKW\DataGridLib\HttpState;
use \MKW\DataGridLib\TableColumn;
use \MKW\DataGridLib\DataSorter;

class HtmlDataGrid implements DataGrid
{
    private $page = 1;
    private $order = 0;
    private $orderBy = 0;
    private $pageSize = 0;
    //private $columns = array();

    /**
     * Zmienia aktualną konfigurację DataGrid.
     */
    public function withConfig(Config $config): DataGrid
    {
        // adds columns from config
        //$this->config->getColumns() = $config->getColumns();
        $this->config = $config;
        return $this;
    }

    /**
     * Renderuje na ekran kod, który ma za zadanie wyświetlić przygotowany DataGrid.
     * Jako parametr przyjmuje: wszystkie dostępne dane, oraz aktualny stan DataGrid w formie obiektu - State.
     * Na podstawie State, metoda ma za zadanie posortować wiersze oraz podzielić je na strony.
     */
    public function render(array $rows, State $state): string
    {
        /**
         * Possible problems:
         * - $rows is not an array
         * - no columns given
         */
        if (!is_array($rows)) {
            return $this->getCriticalErrorHtml("Wprowadzone dane nie są tablicą");
        } else if (count($this->config->getColumns()) == 0) {
            return $this->getCriticalErrorHtml("Brak kolumn do wyświetlenia");
        } else {
            $tableHtml = $this->getTableHtml($rows, $state);
            $paginationHtml = $this->getPaginationHtml($rows, $state);
            return $tableHtml.$paginationHtml;
        }
    }

    private function getCriticalErrorHtml(string $err): string
    {
        return '
        <div class="alert alert-danger" role="alert">
            <svg class="bi bi-exclamation-triangle-fill" width="1em"
            height="1em" viewBox="0 0 16 16" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8.982 1.566a1.13 1.13 0 0 0-1.96
            0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 
            1.438-.99.98-1.767L8.982 1.566zM8 5a.905.905 0 0 0-.9.995l.35
            3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 5zm.002 6a1 1 0 1 0
            0 2 1 1 0 0 0 0-2z"></path>
            </svg> Bład krytyczny - '.$err.'
        </div>';
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
    private function getTableHtml(array $rows, State $state): string
    {
        $sorter = new DataSorter();
        $sortedRows = $sorter->sort($rows, $state, $this->config->getColumns());
        $currentPageRows = $sorter->getCurrentPageRows($sortedRows, $state);

        $tableTop = $this->getTableTop();
        $thead = $this->getTableHead($state);
        $tableMiddle = $this->getTableMiddle();
        $tbody = $this->getTableBody($currentPageRows);
        $tableBottom = $this->getTableBottom();
        
        return $tableTop.$thead.$tableMiddle.$tbody.$tableBottom;
    }


    private function getCurrentPageRows($rows, $state): array
    {
        function sortRows($a, $b)
        {
            //
        }

        $sortedRows = usort($rows, "sortRows");
        $cpr = array();
        return $cpr;
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

    private function getTableHead(State $state): string
    {
        $html = "<tr>";
        foreach($this->config->getColumns() as $col) {
            $column = $col['column'];
            //$html .= "<td><b>".$column->getLabel()."</b></td>";
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

    private function getTableBody($currentPageRows): string
    {
        $html = "";
        foreach($currentPageRows as $row) {
            $html .= $this->getRowHtml($row);
        }
        return $html;
    }

    private function getRowHtml($row): string
    {
        $html = "<tr>";
        if (is_array($row)) {
            foreach($this->config->getColumns() as $col) {
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

    private function getPaginationHtml(array $rows, State $state): string
    {
        $currentPage = $state->getCurrentPage();
        $pagesCount = $this->countPages($rows, $state);

        $baseLink = $this->getBaseButtonLink($state);
        
        $start = "<nav class='mt-2'><ul class='pagination justify-content-center'>";
        $prevPageButton = $this->getPreviousPageButtonHtml($baseLink, $currentPage, $pagesCount);
        $middle = $this->getPageButtonsHtml($baseLink, $currentPage, $pagesCount);
        $nextPageButton = $this->getNextPageButtonHtml($baseLink, $currentPage, $pagesCount);
        $end = "</ul></nav>";

        $paginationHtml = $start.$prevPageButton.$middle.$nextPageButton.$end;
        return $paginationHtml;
    }

    private function countPages(array $rows, State $state): int
    {
        $pagesCount = intdiv(count($rows), $state->getRowsPerPage());
        if (count($rows) % $state->getRowsPerPage() > 0)
        {
            $pagesCount++;
        }

        return $pagesCount;
    }

    private function getBaseButtonLink(State $state): string
    {
        $order = $state->getOrder();
        $orderBy = $state->getOrderBy();
        $baseLink = "index.php?order=$order&orderBy=$orderBy&page=";
        return $baseLink;
    }

    private function getPreviousPageButtonHtml(string $baseLink, int $currentPage, int $pagesCount): string
    {
        $prevPage = $currentPage-1;

        if ($currentPage == 1) {
            $html = "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
        } else {
            $html = "<li class='page-item'><a class='page-link' href='".$baseLink.$prevPage."'>Previous</a></li>";
        }

        return $html;
    }

    private function getNextPageButtonHtml(string $baseLink, int $currentPage, int $pagesCount): string
    {
        $nextPage = $currentPage+1;

        if ($currentPage == $pagesCount)
        {
            $html = "<li class='page-item disabled'><a class='page-link' href='#'>Next</a></li>";
        } else {
            $html = "<li class='page-item'><a class='page-link' href='".$baseLink.$nextPage."'>Next</a></li>";
        }

        return $html;
    }

    private function getPageButtonsHtml(string $baseLink, int $currentPage, int $pagesCount): string
    {
        $html = "";
        for($i = 1; $i <= $pagesCount; $i++)
        {
            if ($i == $currentPage) {
                $html .= "<li class='page-item active'><a class='page-link' href='".$baseLink.$i."'>".$i."</a></li>";
            } else {
                $html .= "<li class='page-item'><a class='page-link' href='".$baseLink.$i."'>".$i."</a></li>";
            }
        }
        return $html;
    }
}