<?php
namespace Commission\Calculator;

use Commission\Providers\BinProviderInterface;
use Commission\Providers\ExchangeRateProviderInterface;

class CommissionCalculator {
    private $binProvider;
    private $rateProvider;

    public function __construct(BinProviderInterface $binProvider, ExchangeRateProviderInterface $rateProvider) {
        $this->binProvider = $binProvider;
        $this->rateProvider = $rateProvider;
    }

    // public function calculate($transaction): string {
    //     $isEu = $this->binProvider->isEu($transaction->bin);
    //     $rate = $this->rateProvider->getRate($transaction->currency);
    //     $amount = $transaction->amount;
    //     if ($transaction->currency !== 'EUR') {
    //         $amount = $amount / $rate;
    //     }
    //     $commission = $amount * ($isEu ? 0.01 : 0.02);
    //     return number_format(ceil($commission * 100) / 100, 2);
    // }

    public function calculate($transaction): string {
    $isEu = $this->binProvider->isEu($transaction->bin);
    $rate = $this->rateProvider->getRate($transaction->currency);
    $amount = $transaction->amount;

    // Ensure rate is valid
    if ($transaction->currency !== 'EUR') {
        if ($rate == 0 || $rate === null) {
            throw new \Exception("Exchange rate cannot be zero or null for currency: {$transaction->currency}");
        }
        $amount = $amount / $rate;
    }

    $commission = $amount * ($isEu ? 0.01 : 0.02);
    return number_format(ceil($commission * 100) / 100, 2);
}

}