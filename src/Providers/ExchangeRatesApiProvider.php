<?php
namespace Commission\Providers;

class ExchangeRatesApiProvider implements ExchangeRateProviderInterface {
    public function getRate(string $currency): float {
        $data = json_decode(file_get_contents('https://api.exchangerate.host/latest'), true);
        return $currency === 'EUR' ? 1.0 : $data['rates'][$currency] ?? 0.0;
    }
}

// $response = file_get_contents('https://api.exchangerate.host/latest');
