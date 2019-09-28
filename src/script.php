<?php

require __DIR__ . '/../vendor/autoload.php';

$filename = '';

if (isset($argc, $argv[1])) {
    if (file_exists($argv[1])) {
        $filename = $argv[1];

        $importer = new FeeCalculation\CsvImporter($filename);
        $calc = new FeeCalculation\FeeCalculation();

        $data = $importer->get();

        foreach ($calc->calculate($data) AS $value) {
            echo $value . PHP_EOL;
        }

    } else {
        echo 'File does not exist' . PHP_EOL;
    }
} else {
    echo 'argc and argv disabled' . PHP_EOL;
}
