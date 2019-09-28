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
    protected $class;

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

        if (Storage::getTotal($this->transaction->get('user_id'), $this->transaction->get('date')) < Conf::MAX_WEEK_FREE
            && Storage::getCount($this->transaction->get('user_id'), $this->transaction->get('date')) <= Conf::MAX_OUT_FREE) {

            if (
                Converter::inEur($this->transaction->get('amount'), $this->transaction->get('currency')) >
                Conf::MAX_WEEK_FREE
            ) {
                $fee_out = Round::up($this->getDiscount() * Conf::OUT_PROC, Decimals::get($this->transaction->get('currency')));
            }

        } else {
            $fee_out = Round::up($this->transaction->get('amount') * Conf::OUT_PROC, Decimals::get($this->transaction->get('currency')));
        }

        Storage::save($this->transaction);

        return $fee_out;
    }

    protected function getDiscount()
    {
        return ('EUR' === $this->transaction->get('currency')) ?
            $this->transaction->get('amount') - Conf::MAX_WEEK_FREE :
            $this->transaction->get('amount') - Converter::convert(Conf::MAX_WEEK_FREE, 'EUR', $this->transaction->get('currency'));
    }
}
