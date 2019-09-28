<?php

namespace FeeCalculation;

interface TransactionInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function setData(array $data);

    /**
     * @return float
     */
    public function getRate(): float;

    /**
     * @param $name
     * @return mixed
     */
    public function get($name);
}
