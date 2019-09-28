<?php

namespace FeeCalculation\Converter;

use Exception as ExceptionAlias;

interface ConverterInterface
{
    /**
     *
     * protected static $rates // array()
     *
     *
     * @param $amount
     * @param $from
     * @param $to
     * @param int $precision
     * @return float
     * @throws ExceptionAlias
     */
    public static function convert($amount, string $from, string $to, $precision = 2): float;

    /**
     * @param array $rates
     */
    public static function setRates($rates): void;

    /**
     * @param $amount
     * @param $currency
     * @return float
     */
    public static function inEur($amount, $currency): float;
}
