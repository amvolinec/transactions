<?php

namespace FeeCalculation;

use Exception as ExceptionAlias;
use FeeCalculation\Config as Conf;
use FeeCalculation\Converter\Converter;
use FeeCalculation\Decimals as Decimals;
use FeeCalculation\InMemoryStorage as Storage;

class RateNaturalCashOut implements Rate
{

    protected $transaction;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return mixed
     * @throws ExceptionAlias
     */
    public function getRate()
    {
        $fee_out = 0;

        if (Storage::getTotal($this->transaction->getUserId(), $this->transaction->getDate()) < Conf::MAX_WEEK_FREE
            && Storage::getCount($this->transaction->getUserId(), $this->transaction->getDate()) <= Conf::MAX_OUT_FREE) {

            if (
                Converter::inEur($this->transaction->getAmount(), $this->transaction->getCurrency()) >
                Conf::MAX_WEEK_FREE
            ) {
                $fee_out = Round::up($this->getDiscount() * Conf::OUT_PROC, Decimals::get($this->transaction->getCurrency()));
            }

        } else {
            $fee_out = Round::up($this->transaction->getAmount() * Conf::OUT_PROC, Decimals::get($this->transaction->getCurrency()));
        }

        Storage::save($this->transaction);

        return $fee_out;
    }

    protected function getDiscount()
    {
        return ('EUR' === $this->transaction->getCurrency()) ?
            $this->transaction->getAmount() - Conf::MAX_WEEK_FREE :
            $this->transaction->getAmount() - Converter::convert(Conf::MAX_WEEK_FREE, 'EUR', $this->transaction->getCurrency());
    }
}
