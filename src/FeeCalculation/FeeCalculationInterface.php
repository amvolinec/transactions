<?php
namespace FeeCalculation;

interface FeeCalculationInterface
{


    /**
     * @param array $data
     * @return array
     */
    public function calculate(array $data): array;
}
