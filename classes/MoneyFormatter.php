<?php


namespace OFFLINE\SnipcartShop\Classes;


trait MoneyFormatter
{

    protected function formatMoney($value)
    {
        return money_format('%.2n', $value);
    }

}