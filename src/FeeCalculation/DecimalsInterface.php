<?php
namespace FeeCalculation;

interface DecimalsInterface
{
    /**
     * @param $currency
     * @return mixed
     */
    public static function get($currency);
}
