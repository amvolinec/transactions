<?php

namespace FeeCalculation\Converter;

use Exception as ExceptionAlias;
use FeeCalculation\Decimals;
use FeeCalculation\Round;

class Converter implements ConverterInterface
{
    // Don't change rates manually. Only thru method setRates()!
    protected static $rates = array('EUR' => 1, 'USD' => 1.1497, 'JPY' => 129.53);

    /**
     * @param array $rates
     */
    public static function setRates($rates): void
    {
        self::$rates = $rates;
    }

    /**
     * @param $amount
     * @param $currency
     * @return float
     * @throws ExceptionAlias
     */
    public static function inEur($amount, $currency): float
    {
        if (!isset(self::$rates[$currency])) {
            throw new \RuntimeException('Currency not found ' . $currency, 100);
        }
        return ('EUR' === $currency) ? $amount : self::convert($amount, $currency, 'EUR');
    }

    /**
     * @param int $amount
     * @param $from
     * @param $to
     * @param int $precision
     * @return float
     * @throws ExceptionAlias
     */
    public static function convert($amount, string $from, string $to, $precision = 2): float
    {
        if (!isset(self::$rates[$from])) {
            throw new \RuntimeException('Currency not found ' . $from, 100);
        }

        if (!isset(self::$rates[$from])) {
            throw new \RuntimeException('Currency not found ' . $to, 100);
        }

        return (Round::up((($amount / self::$rates[$from]) * self::$rates[$to]), Decimals::get($to)));
    }
}

