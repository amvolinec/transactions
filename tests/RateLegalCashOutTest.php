<?php


use FeeCalculation\RateLegalCashOut;
use FeeCalculation\Transaction;
use PHPUnit\Framework\TestCase;

class RateLegalCashOutTest extends TestCase
{

    public function testGetRate(): void
    {
        $transaction = new Transaction();
        $this->assertIsObject($transaction);

        $transaction->setData(['2019-01-01', '1', 'legal', 'cash_in', 1000.00, 'EUR']);
        $rate = new RateLegalCashOut($transaction);
        $result = $rate->getRate();

        $this->assertSame(3.00, $result);

        $transaction->setData(['2019-01-01', '1', 'legal', 'cash_in', 100.00, 'EUR']);
        $rate = new RateLegalCashOut($transaction);
        $result = $rate->getRate();

        $this->assertSame(0.50, $result);

        $transaction->setData(['2019-01-01', '1', 'legal', 'cash_in', 1000, 'JPY']);
        $rate = new RateLegalCashOut($transaction);
        $result = $rate->getRate();

        $this->assertSame(65.00, $result);

        $transaction->setData(['2019-01-01', '1', 'legal', 'cash_in', 100, 'JPY']);
        $rate = new RateLegalCashOut($transaction);
        $result = $rate->getRate();

        $this->assertSame(65.00, $result);

        $transaction->setData(['2019-01-01', '1', 'legal', 'cash_in', 20, 'USD']);
        $rate = new RateLegalCashOut($transaction);
        $result = $rate->getRate();

        $this->assertSame(0.58, $result);
    }
}
