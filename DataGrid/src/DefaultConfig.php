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

    public function addIntColumn(string $key): Config
    {
        $type = new NumberType();
        $col = (new TableColumn())
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign("right")
        ;
        $this->addColumn($key, $col);
        return $this;
    }

    public function addTextColumn(string $key): Config
    {
        $type = new TextType();
        $col = (new TableColumn())
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign("left")
        ;
        $this->addColumn($key, $col);
        return $this;
    }

    public function addCurrencyColumn(string $key, string $currency): Config
    {
        $type = (new MoneyType())
            ->withCurrency($currency)
        ;
        $col = (new TableColumn())
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign("right")
        ;

        $this->addColumn($key, $col);
        return $this;
    }

    public function addImageColumn(string $key): Config
    {
        $type = (new ImageType())
            ->setHeight($this->imageHeight)
            ->setWidth($this->imageWidth);
        
        $col = (new TableColumn())
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign("center")
        ;
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
        $type = (new LinkType())
            ->setTag($this->linkTag)
            ->setClass($this->linkClass);
        
        $col = (new TableColumn())
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign("center")
        ;
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
        $type = (new DateType())
            ->setDateFormat($this->dateFormat);
        
        $col = (new TableColumn())
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign("right")
        ;
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
        $type = (new DateTimeType())
            ->setDateTimeFormat($this->dateTimeFormat);
        
        $col = (new TableColumn())
            ->withLabel($key)
            ->withDataType($type)
            ->withAlign("right")
        ;
        $this->addColumn($key, $col);
        return $this;
    }

    public function setDateTimeFormat(string $val): Config
    {
        $this->dateFormat = $val;
        return $this;
    }
}