<?php
namespace Commission\Providers;

class ExchangeRatesApiProvider implements ExchangeRateProviderInterface {
    public function getRate(string $currency): float {
        $apiKey = getenv('EXCHANGE_API_KEY');
        if (!$apiKey) {
            throw new \Exception("API key not set. Make sure it is in your .env file.");
        }

        $url = "https://api.exchangerate.host/latest?access_key=$apiKey";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            throw new \Exception("Failed to fetch exchange rates.");
        }

        $data = json_decode($response, true);
        if (!isset($data['rates'][$currency])) {
            throw new \Exception("Currency rate not found for: $currency");
        }

        return (float) $data['rates'][$currency];
    }
}
