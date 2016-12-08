<?php
if ( ! function_exists('format_money')) {
    /**
     * Formats a price. Adds the currency if provided.
     *
     * @param string $value
     * @param null   $currency
     *
     * @return string
     */
    function format_money($value, $currency = null)
    {
        $number = money_format('%.2n', $value);

        if ($currency) {
            $number = "${currency} ${number}";
        }

        return $number;
    }
}
