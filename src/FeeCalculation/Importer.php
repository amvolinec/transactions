<?php
namespace FeeCalculation;

interface Importer
{
    /**
     * CsvImporter constructor.
     * @param string $file_name
     */
    public function __construct(string $file_name);

    /**
     *
     */
    public function __destruct();

    /**
     * @return Array
     */
    public function get(): Array;
}
