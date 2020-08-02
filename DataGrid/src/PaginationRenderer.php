<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\State;

class PaginationRenderer
{
    public function renderPagination(array $rows, State $state): string
    {
        $currentPage = $state->getCurrentPage();
        $pagesCount = $this->countPages($rows, $state);

        $baseLink = $this->getBaseButtonLink($state);
        
        $start = $this->getPaginationStart();
        $prevPageButton = $this->getPreviousPageButtonHtml($baseLink, $currentPage, $pagesCount);
        $middle = $this->getPageButtonsHtml($baseLink, $currentPage, $pagesCount);
        $nextPageButton = $this->getNextPageButtonHtml($baseLink, $currentPage, $pagesCount);
        $end = $this->getPaginationEnd();

        $paginationHtml = $start.$prevPageButton.$middle.$nextPageButton.$end;
        return $paginationHtml;
    }

    private function getPaginationStart(): string
    {
        return "<nav class='mt-2'><ul class='pagination justify-content-center'>";
    }

    private function getPaginationEnd(): string
    {
        return "</ul></nav>";
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