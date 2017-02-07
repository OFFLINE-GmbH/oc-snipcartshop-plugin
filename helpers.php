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
        setlocale(LC_ALL, '');
        $locale = localeconv();

        $number = number_format((float)$value, 2, $locale['decimal_point'], $locale['thousands_sep']);

        if ($currency) {
            $number = "${currency} ${number}";
        }

        return $number;
    }
}
