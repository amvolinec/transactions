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
        $rate = new GetRate();
        return $rate->getRate($this);
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserType()
    {
        return $this->user_type;
    }

    public function getOperationType()
    {
        return $this->operation_type;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}
