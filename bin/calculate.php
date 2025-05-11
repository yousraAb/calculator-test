<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Commission\Calculator\CommissionCalculator;
use Commission\Providers\BinListProvider;
use Commission\Providers\ExchangeRatesApiProvider;

$binProvider = new BinListProvider();
$exchangeRateProvider = new ExchangeRatesApiProvider();
$calculator = new CommissionCalculator($binProvider, $exchangeRateProvider);

$inputFile = $argv[1] ?? null;
if (!$inputFile || !file_exists($inputFile)) {
    echo "Input file not found.";
    exit(1);
}

foreach (file($inputFile) as $line) {
    $transaction = json_decode($line);
    echo $calculator->calculate($transaction) . PHP_EOL;
}