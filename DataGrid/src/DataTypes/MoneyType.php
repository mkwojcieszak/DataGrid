<?php

namespace MKW\DataGridLib\DataTypes;

use \MKW\DataGridLib\Interfaces\DataType;

class MoneyType implements DataType
{
    private $currency;
    private $orderType = "Numbers";

    public function getOrderType(): string
    {
        return $this->orderType;
    }
    
    public function withCurrency(string $currency): MoneyType
    {
        if ($currency == "PLN" ||$currency == "USD" ||$currency == "BHD") {
            $this->currency = $currency;
        } else {
            $this->currency = "";
        }
        
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function format(string $value): string
    {
        $curr = $this->currency;
        if ($curr != "") {
            return $value."&nbsp".$curr;
        } else {
            return "Błąd - błędna waluta";
        }
    }
}