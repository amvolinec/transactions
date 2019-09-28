<?php
namespace FeeCalculation;

use Exception as ExceptionAlias;
use FeeCalculation\Config as Conf;
use FeeCalculation\Converter\Converter;
use FeeCalculation\Decimals as Decimals;

class RateCashIn implements Rate
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
        $fee = Round::up($this->transaction->get('amount') * Conf::DEPOSIT_PROC, Decimals::get($this->transaction->get('currency')));

        if (Converter::inEur($fee, $this->transaction->get('currency')) > Conf::MAX_DEPOSIT_FEE) {
            return ('EUR' === $this->transaction->get('currency')) ? Conf::MAX_DEPOSIT_FEE : Converter::convert(Conf::MAX_DEPOSIT_FEE, 'EUR', $this->transaction->get('currency'));
        } else {
            return $fee;
        }
    }
}
