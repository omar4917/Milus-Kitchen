<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    protected string $baseCurrency = 'BDT';
    
    // Exchange rates (BDT to other currencies) - Updated periodically
    protected array $defaultRates = [
        'BDT' => 1,
        'USD' => 0.0091,
        'EUR' => 0.0084,
        'GBP' => 0.0072,
        'INR' => 0.76,
        'AED' => 0.033,
        'SAR' => 0.034,
        'MYR' => 0.043,
        'SGD' => 0.012,
        'CAD' => 0.012,
        'AUD' => 0.014,
    ];

    protected array $currencySymbols = [
        'BDT' => '৳',
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'INR' => '₹',
        'AED' => 'د.إ',
        'SAR' => '﷼',
        'MYR' => 'RM',
        'SGD' => 'S$',
        'CAD' => 'C$',
        'AUD' => 'A$',
    ];

    public function detectCurrency(): string
    {
        // Try to get from session first
        $sessionCurrency = session('currency');
        if ($sessionCurrency) {
            return $sessionCurrency;
        }

        // Detect from IP
        $currency = $this->getCurrencyFromIP();
        session(['currency' => $currency]);
        
        return $currency;
    }

    protected function getCurrencyFromIP(): string
    {
        try {
            $ip = request()->ip();
            
            // Skip for localhost
            if ($ip === '127.0.0.1' || $ip === '::1') {
                return 'BDT';
            }

            // Cache the result for 24 hours
            return Cache::remember("currency_ip_{$ip}", 86400, function () use ($ip) {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                
                if ($response->ok()) {
                    $data = $response->json();
                    $countryCode = $data['countryCode'] ?? 'BD';
                    return $this->getCountryCurrency($countryCode);
                }
                
                return 'BDT';
            });
        } catch (\Exception $e) {
            return 'BDT';
        }
    }

    protected function getCountryCurrency(string $countryCode): string
    {
        $countryCurrencies = [
            'BD' => 'BDT',
            'US' => 'USD',
            'GB' => 'GBP',
            'DE' => 'EUR',
            'FR' => 'EUR',
            'ES' => 'EUR',
            'IT' => 'EUR',
            'IN' => 'INR',
            'AE' => 'AED',
            'SA' => 'SAR',
            'MY' => 'MYR',
            'SG' => 'SGD',
            'CA' => 'CAD',
            'AU' => 'AUD',
        ];

        return $countryCurrencies[$countryCode] ?? 'BDT';
    }

    public function convert(float $amount, ?string $toCurrency = null): float
    {
        $toCurrency = $toCurrency ?? $this->detectCurrency();
        
        if ($toCurrency === $this->baseCurrency) {
            return $amount;
        }

        $rate = $this->defaultRates[$toCurrency] ?? 1;
        return round($amount * $rate, 2);
    }

    public function format(float $amount, ?string $currency = null): string
    {
        $currency = $currency ?? $this->detectCurrency();
        $convertedAmount = $this->convert($amount, $currency);
        $symbol = $this->currencySymbols[$currency] ?? $currency;
        
        return $symbol . number_format($convertedAmount, 2);
    }

    public function getSymbol(?string $currency = null): string
    {
        $currency = $currency ?? $this->detectCurrency();
        return $this->currencySymbols[$currency] ?? $currency;
    }

    public function setCurrency(string $currency): void
    {
        if (isset($this->defaultRates[$currency])) {
            session(['currency' => $currency]);
        }
    }

    public function getAvailableCurrencies(): array
    {
        return array_keys($this->currencySymbols);
    }
}
