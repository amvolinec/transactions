<?php

use FeeCalculation\InMemoryStorage as Storage;
use FeeCalculation\Transaction;
use PHPUnit\Framework\TestCase;

class InMemoryStorageTest extends TestCase
{

    public function testLoad(): void
    {
        $transaction = new Transaction();
        $this->assertIsObject($transaction);
    }

    public function testGetTotal(): void
    {
        $transaction = new Transaction();
        $this->assertIsObject($transaction);
        $this->assertSame(0.00, Storage::getTotal('1', '2019-01-01'));

        $transaction->setData(['2019-01-01', '1', 'natural', 'cash_out', 1000.00, 'EUR']);

        Storage::save($transaction);
        $this->assertSame(1000.00, Storage::getTotal('1', '2019-01-01'));
        $this->assertSame(1, Storage::getCount('1', '2019-01-01'));

        $transaction->setData(['2019-01-01', '1', 'natural', 'cash_out', 1000.00, 'EUR']);

        Storage::save($transaction);
        $this->assertSame(2000.00, Storage::getTotal('1', '2019-01-01'));
        $this->assertSame(2, Storage::getCount('1', '2019-01-01'));

        $transaction->setData(['2018-02-06', '2', 'natural', 'cash_out', 5000.00, 'USD']);
        Storage::save($transaction);

        $this->assertSame(2000.00, Storage::getTotal('1', '2019-01-01'));
        $this->assertSame(4348.97, Storage::getTotal('2', '2018-02-06'));

        $transaction->setData(['2015-05-31', '3', 'natural', 'cash_out', 100000.00, 'JPY']);
        Storage::save($transaction);

        $this->assertSame(2000.00, Storage::getTotal('1', '2019-01-01'));
        $this->assertSame(4348.97, Storage::getTotal('2', '2018-02-06'));
        $this->assertSame(772.03, Storage::getTotal('3', '2015-05-31'));
        $this->assertSame(0.00, Storage::getTotal('3', '2016-05-31'));
        $this->assertSame(0, Storage::getCount('3', '2016-05-31'));
    }

    public function testSave(): void
    {
        $transaction = new Transaction();
        $this->assertIsObject($transaction);
        $transaction->setData(['2014-12-31', '1', 'natural', 'cash_out', 1000.00, 'EUR']);
        $result = Storage::save($transaction);

        $date = date('Ymd', strtotime('monday this week', strtotime('2014-12-31')));
        $this->assertSame('1-' . $date, $result);
    }
}
