<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\State;

class HttpState implements State
{
    private $page;
    private $order;
    private $orderBy;
    private $pageSize = 9;

    public function __construct() {
        $this->loadStateData();
    }

    public function loadStateData() {

        if (isset($_GET['page'])) {
            $this->page = $_GET['page'];
        } else {
            $this->page = 1;
        }

        if (isset($_GET['orderBy'])) {
            $this->orderBy = $_GET['orderBy'];
        } else {
            $this->orderBy = "none";
        }

        if (isset($_GET['order'])) {
            if ($_GET['order'] == "asc") {
                $this->order = "asc";
            } else if ($_GET['order'] == "desc") {
                $this->order = "desc";
            } else {
                $this->order = "none";
            }
        } else {
            $this->order = "none";
        }
    }

    public function getCurrentPage(): int
    {
        return $this->page;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function isOrderDesc(): bool
    {
        if ($this->order == "desc") {
            return true;
        } else {
            return false;
        }
    }

    public function isOrderAsc(): bool
    {
        if ($this->order == "asc") {
            return true;
        } else {
            return false;
        }
    }

    public function getRowsPerPage(): int
    {
        return $this->pageSize;
    }
}