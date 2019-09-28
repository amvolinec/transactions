<?php

namespace FeeCalculation;

interface Storage
{
    public static function save(TransactionInterface $transaction): string;

    public static function getTotal($user_id, $date): float;

    public static function getCount($user_id, $date): int;
}
