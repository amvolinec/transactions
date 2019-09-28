<?php

use FeeCalculation\UserWeek;
use PHPUnit\Framework\TestCase;

class UserWeekTest extends TestCase
{

    public function testGet(): void
    {
        $user = '1';
        $date = '2019-09-26';

        $monday = date('Ymd', strtotime('monday this week', strtotime($date)));
        $this->assertSame($monday, '20190923');

        $user_week = UserWeek::get($user, $date);
        $this->assertSame('1-20190923', $user_week);
    }
}
