<?php
namespace FeeCalculation;

class UserWeek implements UserWeekInterface
{

    public static function get($user, $date): string
    {
        return $user . '-' . date('Ymd', strtotime('monday this week', strtotime($date)));
    }

}
