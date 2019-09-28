<?php

use FeeCalculation\FeeCalculation;
use PHPUnit\Framework\TestCase;

class FeeCalculationTest extends TestCase
{

    public function testMake()
    {
        $data[] = array('2016-01-01', '1', 'natural', 'cash_in', '200.00', 'EUR');
        $data[] = array('2016-01-06', '1', 'natural', 'cash_in', '20000.00', 'EUR');
        $data[] = array('2016-01-07', '1', 'natural', 'cash_in', '10000.00', 'USD');
        $data[] = array('2016-01-08', '1', 'natural', 'cash_in', '30000.00', 'USD');
        $data[] = array('2016-01-08', '1', 'legal', 'cash_out', '100.00', 'EUR');
        $data[] = array('2016-01-08', '1', 'legal', 'cash_out', '100.00', 'USD');
        $data[] = array('2015-31-01', '1', 'natural', 'cash_out', '1200.00', 'EUR');
        $data[] = array('2016-01-01', '1', 'natural', 'cash_out', '1000.00', 'USD');
        $data[] = array('2016-01-08', '1', 'natural', 'cash_out', '10000.00', 'EUR');
        $data[] = array('2016-01-08', '1', 'natural', 'cash_out', '10000.00', 'USD');

        $fee = new FeeCalculation();
        $result = $fee->calculate($data);

        $this->assertSame($result, ['0.06', '5.00', '3.00', '5.75', '0.50', '0.58', '0.60', '0.00', '27.00', '30.00']);
    }

    public function testTask()
    {
        $data[] = array('2014-12-31', 4, 'natural', 'cash_out', 1200.00, 'EUR');
        $data[] = array('2015-01-01', 4, 'natural', 'cash_out', 1000.00, 'EUR');
        $data[] = array('2016-01-05', 4, 'natural', 'cash_out', 1000.00, 'EUR');
        $data[] = array('2016-01-05', 1, 'natural', 'cash_in', 200.00, 'EUR');
        $data[] = array('2016-01-06', 2, 'legal', 'cash_out', 300.00, 'EUR');
        $data[] = array('2016-01-06', 1, 'natural', 'cash_out', 30000, 'JPY');
        $data[] = array('2016-01-07', 1, 'natural', 'cash_out', 1000.00, 'EUR');
        $data[] = array('2016-01-07', 1, 'natural', 'cash_out', 100.00, 'USD');
        $data[] = array('2016-01-10', 1, 'natural', 'cash_out', 100.00, 'EUR');
        $data[] = array('2016-01-10', 2, 'legal', 'cash_in', 1000000.00, 'EUR');
        $data[] = array('2016-01-10', 3, 'natural', 'cash_out', 1000.00, 'EUR');
        $data[] = array('2016-02-15', 1, 'natural', 'cash_out', 300.00, 'EUR');
        $data[] = array('2016-02-19', 2, 'natural', 'cash_out', 3000000, 'JPY');

        $fee = new FeeCalculation();
        $result = $fee->calculate($data);

        $this->assertSame($result, array(
            '0.60',
            '3.00',
            '0.00',
            '0.06',
            '0.90',
            '0',
            '0.00',
            '0.30',
            '0.30',
            '5.00',
            '0.00',
            '0.00',
            '8612'));
    }
}
