<?php


use FeeCalculation\RateCashIn;
use FeeCalculation\Transaction;
use PHPUnit\Framework\TestCase;

class RateCashInTest extends TestCase
{
    public function testGetRate(): void
    {
        $transaction = new Transaction();
        $this->assertIsObject($transaction);

        $transaction->setData(['2019-01-01', '1', 'legal', 'cash_in', 1000.00, 'EUR']);
        $rate = new RateCashIn($transaction);
        $result = $rate->getRate();

        $this->assertSame(0.30, $result);

        $transaction->setData(['2019-01-01', '1', 'legal', 'cash_in', 50000.00, 'EUR']);
        $rate = new RateCashIn($transaction);
        $result = $rate->getRate();

        $this->assertSame(5.00, $result);
    }
}
