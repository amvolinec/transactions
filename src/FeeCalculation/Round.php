<?php

namespace FeeCalculation;

class Round
{
    /**
     * @param $value
     * @param $decimal
     * @return float|int
     */
    public static function up($value, $decimal)
    {
        return ceil($value * pow(10, $decimal)) / pow(10, $decimal);
    }
}
