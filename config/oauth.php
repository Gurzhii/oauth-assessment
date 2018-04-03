<?php

return [
    'clientId'                => env('OAUTH_CLIENT_ID'),
    'clientSecret'            => env('OAUTH_CLIENT_SECRET'),
    'redirectUri'             => 'http://oauth.loc/oauth',
    'urlAuthorize'            => env('OAUTH_AUTHORIZE_URL'),
    'urlAccessToken'          => env('OAUTH_ACCESS_TOKEN_URL'),
    'urlResourceOwnerDetails' => '',
    'scopes' => 'firstname+surname+email+phone+pwhash+viber+skype+wechat+trust_level+otp+totp_secret'
];
