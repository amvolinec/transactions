<?php
namespace FeeCalculation;

class Config
{
    public const VERSION = '1.1.0';
    public const DATE = 0;
    public const USER_ID = 1;
    public const USER_TYPE = 2;
    public const OPERATION_TYPE = 3;
    public const AMOUNT = 4;
    public const CURRENCY = 5;
    public const FIELDS_COUNT = 6;
    public const LEGAL = 'legal';
    public const NATURAL = 'natural';
    public const CASH_IN = 'cash_in';
    public const CASH_OUT = 'cash_out';
    public const MAX_DEPOSIT_FEE = 5.00;
    public const DEPOSIT_PROC = 0.0003;
    public const OUT_PROC = 0.003;
    public const MIN_OUT_FEE = 0.50;
    public const MAX_WEEK_FREE = 1000;
    public const MAX_OUT_FREE = 3;
    public const DECIMAL_POINTS = 2;

}
