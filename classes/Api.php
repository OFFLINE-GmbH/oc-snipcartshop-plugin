<?php

namespace OFFLINE\SnipcartShop\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use OFFLINE\SnipcartShop\Models\ApiSettings;

class Api
{
    /**
     * Snipcart API base uri
     * @var string
     */
    const BASE_URI = 'https://app.snipcart.com/api/';
    /**
     * Guzzle Http Client
     * @var Client
     */
    protected $http;

    public function __construct($apiKey = null, ClientInterface $http = null)
    {
        $this->apiKey = $apiKey ?: ApiSettings::get('private_api_key');
        $this->http   = $http ?: new Client([
            'base_uri' => self::BASE_URI,
            'headers'  => ['Accept' => 'application/json'],
            'auth'     => [$this->apiKey, ''], // Second parameter (password) has to be empty
        ]);
    }
}