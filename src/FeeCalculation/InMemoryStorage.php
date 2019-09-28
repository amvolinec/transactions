<?php

namespace FeeCalculation;

use Exception;
use FeeCalculation\Converter\Converter;

class InMemoryStorage implements Storage
{
    protected static $storage;

    public function __construct()
    {
        self::$storage = array();
    }

    /**
     * @param TransactionInterface $transaction
     * @return string
     * @throws Exception
     */
    public static function save(TransactionInterface $transaction): string
    {
        $index = UserWeek::get($transaction->get('user_id'), $transaction->get('date'));
        if (!isset(self::$storage[$index])) {
            self::$storage[$index]['amount'] = 0;
            self::$storage[$index]['count'] = 0;
        }
        self::$storage[$index]['amount'] += Converter::convert($transaction->get('amount'), $transaction->get('currency'), 'EUR');
        self::$storage[$index]['count']++;
        return $index;
    }

    /**
     * @param $user_id
     * @param $date
     * @return float
     */
    public static function getTotal($user_id, $date): float
    {
        $index = UserWeek::get($user_id, $date);

        return self::$storage[$index]['amount'] ?? 0.00;
    }

    public static function getCount($user_id, $date): int
    {
        $index = UserWeek::get($user_id, $date);

        return self::$storage[$index]['count'] ?? 0;
    }


    public static function clear(): void
    {
        self::$storage = array();
    }

    public static function getStorage(): array
    {
        return self::$storage;
    }
}
