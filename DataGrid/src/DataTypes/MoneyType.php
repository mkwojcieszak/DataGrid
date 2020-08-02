<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;

class MoneyType implements DataType
{
    // Możliwość skonfigurowania: dowolnego separatora (tysięcy i miejsca dziesiętnego) oraz wyświetlania miejsc dziesiętnych (można wyłączyć aby nie pokazywać groszy).
    private $currency;
    private $orderType = "Numbers";

    private $moneyTousandsSeparator = " ";
    private $moneyDecimalsSeparator = ",";
    private $showCents = true;

    public function getOrderType(): string
    {
        return $this->orderType;
    }
    
    public function __construct(
        string $currency,
        string $moneyTousandsSeparator,
        string $moneyDecimalsSeparator,
        bool $showCents)
    {
        $this->currency = $currency;
        $this->moneyTousandsSeparator = $moneyTousandsSeparator;
        $this->moneyDecimalsSeparator = $moneyDecimalsSeparator;
        $this->showCents = $showCents;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function format(string $value): string
    {
        if ($this->currency != "PLN" && $this->currency != "USD" && $this->currency != "BHD") {
            return '<svg class="bi bi-exclamation-triangle-fill" width="1em" height="1em"
            viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165
            13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982
            1.566zM8 5a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905
            0 0 0 8 5zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
            </svg> Błędna waluta';
        } else {
            $value = strip_tags($value);
            $this->showCents ? $decimals = 2 : $decimals = 0;
            $value = number_format($value, $decimals, $this->moneyDecimalsSeparator ,$this->moneyTousandsSeparator);
            $value .= " ".$this->currency;
            $value = str_replace(" ", "&nbsp", $value);
            return $value;
        }
    }
}