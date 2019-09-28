<?php
namespace FeeCalculation;

interface Rate

{

    public function __construct(TransactionInterface $transaction);

    /**
     * @return mixed
     */
    public function getRate();
}
