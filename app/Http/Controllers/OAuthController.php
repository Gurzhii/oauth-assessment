<?php

namespace App\Http\Controllers;

use App\Services\OAuthService;

class OAuthController extends Controller
{
    public function login()
    {
        if (! session('oauth_user')) {
            OAuthService::create()->login();
        }
        return redirect()->route('main.index');
    }
}
