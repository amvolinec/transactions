<?php


namespace FeeCalculation;

use FeeCalculation\Config as Conf;

class GetRate extends RateState
{

    /**
     * @param TransactionInterface $transaction
     * @return float
     */
    public function getRate(TransactionInterface $transaction): float
    {
        $result = 0;
        try {
            switch ($transaction->getUserType() . $transaction->getOperationType()) {
                case Conf::NATURAL . Conf::CASH_IN:
                case Conf::LEGAL . Conf::CASH_IN :
                    $result = (new RateCashIn($transaction))->getRate();
                    break;
                case Conf::LEGAL . Conf::CASH_OUT :
                    $result = (new RateLegalCashOut($transaction))->getRate();
                    break;
                case Conf::NATURAL . Conf::CASH_OUT:
                    $result = (new RateNaturalCashOut($transaction))->getRate();
                    break;
                default:
                    throw new \RuntimeException('Invalid user or operation types ' . $transaction->getUserType() . $transaction->getOperationType());

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $result;
    }
}