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
use \MKW\DataGridLib\TableRenderer;
use \MKW\DataGridLib\PaginationRenderer;

class HtmlDataGrid implements DataGrid
{
    public function render(array $rows, State $state, Config $config): string
    {
        if (!is_array($rows)) {
            return $this->getCriticalErrorHtml("Wprowadzone dane nie są tablicą");
        } else if (count($config->getColumns()) == 0) {
            return $this->getCriticalErrorHtml("Brak kolumn do wyświetlenia");
        } else {
            $tableHtml = (new TableRenderer)->renderTable($rows, $state, $config);
            $paginationHtml = (new PaginationRenderer)->renderPagination($rows, $state);
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
}