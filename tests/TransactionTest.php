<?php

use FeeCalculation\Config as Conf;
use FeeCalculation\Decimals;
use FeeCalculation\Transaction;
use PHPUnit\Framework\TestCase;
use FeeCalculation\InMemoryStorage AS Storage;

class TransactionTest extends TestCase
{

    public function testGetRate(): void
    {
        Storage::clear();
        $data = array('2014-12-31', 4, 'natural', 'cash_out', 1200.00, 'EUR');

        $this->assertSame(count($data), 6);

        $transaction = new Transaction($data);
        $result = $transaction->setData($data)->getRate();

        $this->assertSame($result, 0.60);
    }

    public function testLegalCashIn()
    {
        $data = array('2014-12-31', 1, 'legal', 'cash_in', 100.00, 'EUR');

        $this->assertSame(count($data), 6);

        $transaction = new Transaction();
        $result = $transaction->setData($data)->getRate();

        $fee = round(100 * Conf::DEPOSIT_PROC, Decimals::get('EUR'), PHP_ROUND_HALF_UP);

        $this->assertSame($fee, 0.03);
        $this->assertSame($result, $fee);

        $result = $transaction->setData(array('2014-12-31', 1, 'legal', 'cash_in', 1000.00, 'EUR'))->getRate();
        $this->assertSame($result, 0.30);

        $result = $transaction->setData(array('2014-12-31', 1, 'legal', 'cash_in', 10000.00, 'USD'))->getRate();
        $this->assertSame($result, 3.00);

        $result = $transaction->setData(array('2014-12-31', 1, 'legal', 'cash_in', 20000.00, 'USD'))->getRate();
        $this->assertSame($result, 5.75);

        $result = $transaction->setData(array('2016-02-05', 1, 'legal', 'cash_in', 20000.00, 'JPY'))->getRate();
        $this->assertSame($result, 6.00);

    }

    public function testNaturalCashIn(): void
    {
        $transaction = new Transaction();
        $result = $transaction->setData(array('2015-12-31', 1, 'natural', 'cash_in', 1000.00, 'EUR'))->getRate();
        $this->assertSame($result, 0.30);

        $result = $transaction->setData(array('2015-12-31', 1, 'natural', 'cash_in', 1000.00, 'USD'))->getRate();
        $this->assertSame($result, 0.30);

        $result = $transaction->setData(array('2015-12-31', 1, 'natural', 'cash_in', 10000.00, 'JPY'))->getRate();
        $this->assertSame($result, 3.00);

        $result = $transaction->setData(array('2015-12-31', 1, 'natural', 'cash_in', 12345.00, 'JPY'))->getRate();
        $this->assertSame($result, 4.00);

        $result = $transaction->setData(array('2015-12-31', 1, 'natural', 'cash_in', 20000.00, 'USD'))->getRate();
        $this->assertSame($result, 5.75);

        $result = $transaction->setData(array('2016-02-05', 1, 'natural', 'cash_in', 20000.00, 'JPY'))->getRate();
        $this->assertSame($result, 6.00);
    }

    public function testLegalCashOut(): void
    {
        $transaction = new Transaction();
        $result = $transaction->setData(array('2015-01-22', 2, 'legal', 'cash_out', 1200.00, 'EUR'))->getRate();
        $this->assertSame($result, 3.6);
    }

    public function testNaturalCashOut(): void
    {
        Storage::clear();
        $transaction = new Transaction();
        $result = $transaction->setData(array('2014-12-31', 4, 'natural', 'cash_out', 1200.00, 'EUR'))->getRate();
        $this->assertSame($result, 0.60);

        $result = $transaction->setData(array('2015-01-01', 4, 'natural', 'cash_out', 1000.00, 'EUR'))->getRate();
        $this->assertSame($result, 3.00);

        $result = $transaction->setData(array('2016-02-19', 2, 'natural', 'cash_out', 3000000, 'JPY'))->getRate();
        $this->assertSame($result, 8612.00);
    }
}