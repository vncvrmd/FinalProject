<?php

if (!function_exists('format_peso')) {
    /**
     * Formats a number into Philippine Peso currency.
     *
     * @param float $amount
     * @return string
     */
    function format_peso($amount)
    {
        // number_format(number, decimals, decimal_separator, thousands_separator)
        return '₱' . number_format($amount, 2, '.', ',');
    }
}

if (!function_exists('is_active')) {
    /**
     * Check if a route is currently active.
     *
     * @param string $routeName
     * @return bool
     */
    function is_active($routeName)
    {
        return request()->routeIs($routeName);
    }
}