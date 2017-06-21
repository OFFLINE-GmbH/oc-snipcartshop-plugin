<?php
use OFFLINE\SnipcartShop\Models\CurrencySettings;
use OFFLINE\SnipcartShop\Models\Product;

if ( ! function_exists('format_money')) {
    /**
     * Formats a price. Adds the currency if provided.
     *
     * @param string       $value
     * @param Product|null $product
     * @param null         $currency
     *
     * @return string
     */
    function format_money($value, Product $product = null, $currency = null)
    {
        $format = CurrencySettings::activeCurrencyFormat();

        $value    = (float)$value;
        $integers = floor($value);
        $decimals = ($value - $integers) * 100;

        return Twig::parse($format, [
            'price'    => $value,
            'integers' => $integers,
            'decimals' => str_pad($decimals, 2, '0', STR_PAD_LEFT),
            'product'  => $product,
            'currency' => $currency ?: CurrencySettings::activeCurrency(),
        ]);
    }
}
