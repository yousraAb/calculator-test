<?php
namespace Commission\Providers;

interface ExchangeRateProviderInterface {
    public function getRate(string $currency): float;
}