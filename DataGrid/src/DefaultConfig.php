<?php

namespace MKW\DataGridLib;

use \MKW\DataGridLib\Interfaces\Config;
use \MKW\DataGridLib\Interfaces\Column;

use \MKW\DataGridLib\DataTypes\TextType;
use \MKW\DataGridLib\DataTypes\NumberType;
use \MKW\DataGridLib\DataTypes\MoneyType;
use \MKW\DataGridLib\DataTypes\ImageType;
use \MKW\DataGridLib\DataTypes\LinkType;
use \MKW\DataGridLib\DataTypes\DateType;
use \MKW\DataGridLib\DataTypes\DateTimeType;
use \MKW\DataGridLib\DataTypes\RawType;

use \MKW\DataGridLib\TableColumn;

class DefaultConfig implements Config
{
    private $columns = array();

    private $imageWidth = 16;
    private $imageHeight = 16;

    private $linkTag = "a";
    private $linkClass = "body";

    private $dateFormat = "Y-m-d";
    private $dateTimeFormat = "Y-m-d H:i:s";

    private $numbersTousandsSeparator = " ";
    private $numbersDecimalsSeparator = ",";
    private $numbersDecimals = 2;
    private $staticDecimals = true;
    private $roundingFunction = "round";

    private $moneyTousandsSeparator = " ";
    private $moneyDecimalsSeparator = ",";
    private $showCents = true;


    /**
     * Dodaje nową kolumną do DataGrid.
     */
    public function addColumn(string $key, Column $column): Config
    {
        $col = array();
        $col['label'] = $key;
        $col['column'] = $column;
        $this->columns[] = $col;
        return $this;
    }

    /**
     * Zwraca wszystkie kolumny dla danego DataGrid.
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function addTextColumn(string $key): Config
    {
        $type = new TextType();
        $col = new TableColumn($key, $type, "left");
        $this->addColumn($key, $col);
        return $this;
    }

    public function addRawColumn(string $key): Config
    {
        $type = new RawType();
        $col = new TableColumn($key, $type, "left");
        $this->addColumn($key, $col);
        return $this;
    }

    public function addIntColumn(string $key): Config
    {
        $type = new NumberType(
            $this->numbersTousandsSeparator,
            $this->numbersDecimalsSeparator,
            $this->numbersDecimals,
            $this->staticDecimals,
            $this->roundingFunction);
        $col = new TableColumn($key, $type, "right");
        $this->addColumn($key, $col);
        return $this;
    }

    public function setStaticDecimals(bool $val): Config
    {
        $this->staticDecimals = $val;
        return $this;
    }

    public function setRoundingFunction(string $val): Config
    {
        $val = strtolower($val);
        if ($val == "round" || $val == "floor" || $val == "ceil") {
            $this->roundingFunction = $val;
        }
        return $this;
    }

    public function setNumbersTousandsSeparator(string $val): Config
    {
        $this->numbersTousandsSeparator = $val;
        return $this;
    }

    public function setNumbersDecimalsSeparator(string $val): Config
    {
        $this->numbersDecimalsSeparator = $val;
        return $this;
    }

    public function setNumbersDecimals(int $val): Config
    {
        $this->numbersDecimals = $val;
        return $this;
    }

    public function addCurrencyColumn(string $key, string $currency): Config
    {
        $type = new MoneyType($currency, $this->moneyTousandsSeparator, $this->moneyDecimalsSeparator, $this->showCents);
        $col = new TableColumn($key, $type, "right");

        $this->addColumn($key, $col);
        return $this;
    }

    public function setMoneyTousandsSeparator(string $val): Config
    {
        $this->moneyTousandsSeparator = $val;
        return $this;
    }

    public function setMoneyDecimalsSeparator(string $val): Config
    {
        $this->moneyDecimalsSeparator = $val;
        return $this;
    }

    public function setShowCents(bool $val): Config
    {
        $this->showCents = $val;
        return $this;
    }

    public function addImageColumn(string $key): Config
    {
        $type = new ImageType($this->imageHeight, $this->imageWidth);
        $col = new TableColumn($key, $type, "center");

        $this->addColumn($key, $col);
        return $this;
    }

    public function setImageHeight(int $val): Config
    {
        $this->imageHeight = $val;
        return $this;
    }

    public function setImageWidth(int $val): Config
    {
        $this->imageWidth = $val;
        return $this;
    }

    public function addLinkColumn(string $key): Config
    {
        $type = new LinkType($this->linkTag, $this->linkClass);
        $col = new TableColumn($key, $type, "center");

        $this->addColumn($key, $col);
        return $this;
    }

    public function setLinkTag(string $val): Config
    {
        $this->linkTag = $val;
        return $this;
    }

    public function setLinkClass(string $val): Config
    {
        $this->linkClass = $val;
        return $this;
    }

    public function addDateColumn(string $key): Config
    {
        $type = new DateType($this->dateFormat);
        $col = new TableColumn($key, $type, "right");
        
        $this->addColumn($key, $col);
        return $this;
    }

    public function setDateFormat(string $val): Config
    {
        $this->dateFormat = $val;
        return $this;
    }

    public function addDateTimeColumn(string $key): Config
    {
        $type = new DateTimeType($this->dateTimeFormat);
        $col = new TableColumn($key, $type, "right");

        $this->addColumn($key, $col);
        return $this;
    }

    public function setDateTimeFormat(string $val): Config
    {
        $this->dateTimeFormat = $val;
        return $this;
    }
}