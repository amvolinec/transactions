<?php
namespace FeeCalculation;

use FeeCalculation\Config as Conf;

class Decimals implements DecimalsInterface
{
    protected static $currencies = array('JPY');

    public static function get($currency)
    {
        return in_array($currency, self::$currencies, true) ? 0 : Conf::DECIMAL_POINTS;
    }
}
