<?php


namespace FeeCalculation;

use FeeCalculation\Config as Conf;


abstract class RateState
{
    /**
     * @param TransactionInterface $transaction
     * @return float
     */
    abstract public function getRate(TransactionInterface $transaction): float;
}