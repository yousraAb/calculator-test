<?php
namespace Commission\Providers;

class BinListProvider implements BinProviderInterface {
    public function isEu(string $bin): bool {
        $url = "https://lookup.binlist.net/{$bin}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout after 10 seconds
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Handle HTTP Errors
        if ($httpCode >= 400 || !$response) {
            throw new \Exception("Failed to fetch BIN information. HTTP Status: $httpCode");
        }

        $data = json_decode($response);

        // Validate response
        if (!isset($data->country) || !isset($data->country->alpha2)) {
            throw new \Exception("Invalid BIN data received.");
        }

        $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'];

        return in_array($data->country->alpha2, $euCountries);
    }
}
