<?php

namespace App\Services;

use GuzzleHttp\Client;
use League\OAuth2\Client\Provider\GenericProvider as OAuthProvider;

class OAuthService
{
    protected $client;
    protected $token;
    protected $config;

    const USER_DATA_URL = 'https://testing.e-id.cards/oauth/data';
    const OAUTH_AUTH_URL = 'https://testing.bb.yttm.work:5000/v1/oauth_auth';

    public function __construct()
    {
        $this->client = new Client([
            'curl'            => array( CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false ),
            'allow_redirects' => false,
            'cookies'         => true,
            'verify'          => false
        ]);
        $this->config = [
            'clientId'                => config('oauth.clientId'),
            'clientSecret'            => config('oauth.clientSecret'),
            'redirectUri'             => config('oauth.redirectUri'),
            'urlAuthorize'            => config('oauth.urlAuthorize'),
            'urlAccessToken'          => config('oauth.urlAccessToken'),
            'urlResourceOwnerDetails' => config('oauth.urlResourceOwnerDetails'),
            'scopes'                  => config('oauth.scopes'),
        ];
    }


    public static function create()
    {
        return (new static);
    }
    
    public function login()
    {
        $this->token = $this->getOAuthToken();

        session(['oauth_user' => $this->getUser()]);
    }

    protected function getOAuthToken()
    {
        $provider = new OAuthProvider($this->config);

        if (!isset($_GET['code'])) {
            $authorizationUrl = $provider->getAuthorizationUrl();
            header('Location: ' . $authorizationUrl);
            exit;
        } else {
            try {
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code'],
                    'clientId' => $this->config['clientId'],
                    'clientSecret' => $this->config['clientSecret'],
                    'redirectUri' => $this->config['redirectUri'],
                ]);
                return $accessToken->getToken();
            } catch (\Exception $e) {
                exit($e->getMessage());
            }
        }
    }

    protected function getUser()
    {
        $request = $this->client->request(
            'GET',
            static::USER_DATA_URL,
            [
                'query' => [
                    'access_token' => $this->token
                ]
            ]
        );
        $response = $request->getBody()->getContents();
        $request = $this->client->get(static::OAUTH_AUTH_URL, [
            'query' => json_decode($response, true)
        ]);

        return json_decode($request->getBody()->getContents(), true);
    }
}
