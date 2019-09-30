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

    public function getDate();

    public function getUserId();

    public function getUserType();

    public function getOperationType();

    public function getAmount();

    public function getCurrency();
}
