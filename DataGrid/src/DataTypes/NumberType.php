<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;

class NumberType implements DataType
{
    private $orderType = "Text";
    private $numbersTousandsSeparator;
    private $numbersDecimalSeparator;
    private $numbersDecimals;
    private $roundingFunction;
    private $staticDecimals;

    public function __construct(
        string $numbersTousandsSeparator,
        string $numbersDecimalSeparator,
        int $numbersDecimals,
        bool $staticDecimals,
        string $roundingFunction)
    {
        $this->numbersTousandsSeparator = $numbersTousandsSeparator;
        $this->numbersDecimalSeparator = $numbersDecimalSeparator;
        $this->numbersDecimals = $numbersDecimals;
        $this->staticDecimals = $staticDecimals;
        $this->roundingFunction = $roundingFunction;
    }

    public function getOrderType(): string
    {
        return $this->orderType;
    }

    public function format(string $value): string
    {
        $value = strip_tags($value);
        if ($this->staticDecimals == true) {
            $value *= $this->numbersDecimals;
            if ($this->roundingFunction == "floor") {
                $value = floor($value);
            } else if ($this->roundingFunction == "ceil") {
                $value = ceil($value);
            } else {
                $value = round($value);
            }

            $value /= $this->numbersDecimals;
            $value = number_format($value,
                $this->numbersDecimals,
                $this->numbersDecimalSeparator,
                $this->numbersTousandsSeparator);
        } else {
            $arrs = explode('.', $value);
            $value = number_format($arrs[0], 0, $this->numbersDecimalSeparator ,$this->numbersTousandsSeparator);
            if (isset($arrs[1])) {
                $value .= $this->numbersDecimalSeparator;
                $value .= $arrs[1];
            }
        }

        $value = str_replace(" ", "&nbsp", $value);
        return $value;
    }
}