<?php


use FeeCalculation\Converter\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{

    public function testSetRates()
    {
        $result = Converter::convert(1, 'EUR', 'USD', 2);
        $this->assertSame($result, 1.15);
    }

    public function testConvert()
    {
        $rates = array('EUR' => 1, 'USD' => 1.1497, 'JPY' => 129.53);
        $converter = new Converter();
        $converter->setRates($rates);

        $fee = $converter->convert(1, 'EUR', 'EUR', 2);
        $this->assertSame($fee, 1.00);

        $fee = $converter->convert(1, 'USD', 'USD', 2);
        $this->assertSame($fee, 1.00);

        $fee = $converter->convert(1, 'EUR', 'USD', 2);
        $this->assertSame($fee, 1.15);

        $fee = $converter->convert(1, 'EUR', 'JPY', 2);
        $this->assertSame($fee, 130.00);

        $fee = $converter->convert(1000, 'JPY', 'EUR', 2);
        $this->assertSame($fee, 7.73);

        $fee = $converter->convert(100, 'USD', 'EUR', 2);
        $this->assertSame($fee, 86.98);

        $fee = $converter->convert(1000, 'EUR', 'JPY', 2);
        $this->assertSame($fee, 129530.00);

        $this->expectException("Exception");
        $this->expectExceptionCode(100);
        $this->expectExceptionMessage("Currency not found JPR");
        $converter->convert(1, 'JPR', 'EUR', 2);
    }
}
