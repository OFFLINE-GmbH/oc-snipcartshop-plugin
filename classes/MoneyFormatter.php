<?php


namespace OFFLINE\SnipcartShop\Classes;


trait MoneyFormatter
{

    protected function formatMoney($value, $currency = null)
    {
        $number = money_format('%.2n', $value);

        if ($currency) {
            $number = "${currency} ${number}";
        }

        return $number;
    }

}