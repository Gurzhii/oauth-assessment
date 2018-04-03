<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrenciesService
{
    protected $client;

    const CURRENCIES_RATES_URL = 'https://testing.bb.yttm.work:5000/v1/get_currency_rates';
    const CURRENCIES_URL = 'https://testing.bb.yttm.work:5000/v1/get_currencies';

    public function __construct()
    {
        $this->client = new Client([
            'curl'            => array( CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false ),
            'allow_redirects' => false,
            'cookies'         => true,
            'verify'          => false
        ]);
    }
    
    public function fetchCurrencies()
    {
        $currencies = $this->client->get(static::CURRENCIES_URL)->getBody()->getContents();

        return json_decode($currencies, true);
    }
    
    public function fetchRates()
    {
        $rates = $this->client->get(static::CURRENCIES_RATES_URL)->getBody()->getContents();

        return json_decode($rates, true);
    }
}
