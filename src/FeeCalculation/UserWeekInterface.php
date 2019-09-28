<?php

namespace FeeCalculation;

interface UserWeekInterface
{
    /**
     * @param $user
     * @param $date
     * @return string
     */
    public static function get($user, $date): string;
}
