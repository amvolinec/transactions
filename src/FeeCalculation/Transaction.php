<?php

namespace FeeCalculation;

use FeeCalculation\Config as Conf;

class Transaction implements TransactionInterface
{
    protected $date;
    protected $user_id;
    protected $user_type;
    protected $operation_type;
    protected $amount;
    protected $currency;

    public function setData(array $data)
    {
        if (count($data) < Conf::FIELDS_COUNT) {
            throw new \RuntimeException('Invalid data format');
        }
        $this->date = $data[Conf::DATE];
        $this->user_id = $data[Conf::USER_ID];
        $this->user_type = $data[Conf::USER_TYPE];
        $this->operation_type = $data[Conf::OPERATION_TYPE];
        $this->amount = $data[Conf::AMOUNT];
        $this->currency = $data[Conf::CURRENCY];
        return $this;
    }

    public function getRate(): float
    {
        $result = 0;
        try {
            switch ($this->user_type . $this->operation_type) {
                case Conf::NATURAL . Conf::CASH_IN:
                case Conf::LEGAL . Conf::CASH_IN :
                    $result = (new RateCashIn($this))->getRate();
                    break;
                case Conf::LEGAL . Conf::CASH_OUT :
                    $result = (new RateLegalCashOut($this))->getRate();
                    break;
                case Conf::NATURAL . Conf::CASH_OUT:
                    $result = (new RateNaturalCashOut($this))->getRate();
                    break;
                default:
                    throw new \RuntimeException('Invalid user or operation types ' . $this->user_type . $this->operation_type);

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $result;
    }

    public function get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
    }
}
