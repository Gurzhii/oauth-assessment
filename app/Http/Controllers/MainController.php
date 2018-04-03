<?php

namespace App\Http\Controllers;

use App\Services\CurrenciesService;

class MainController extends Controller
{
    public function index(CurrenciesService $currenciesService)
    {
        if (! session('oauth_user')) {
            return redirect()->route('root');
        }

        $currencies = $currenciesService->fetchCurrencies()['currencies'];
        $rates = $currenciesService->fetchRates()['rates'];

        return view('main.index', compact('currencies', 'rates'));
    }
}
