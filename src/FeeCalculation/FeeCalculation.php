<?php

namespace FeeCalculation;

use Exception;
use FeeCalculation\Config as Conf;
use FeeCalculation\InMemoryStorage as Storage;

class FeeCalculation implements FeeCalculationInterface
{
    protected $data;
    protected $result = array();
    protected $transaction;

    /**
     * FeeCalculation constructor.
     */
    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    /**
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function calculate(array $data): array

    {
        $this->data = $data;
        Storage::clear();

        foreach ($this->data AS $value) {

            $this->result[] = number_format(
                $this->transaction->setData($value)->getRate(),
                Decimals::get($value[Conf::CURRENCY]),
                '.',
                '');
        }

        return $this->result;
    }
}
