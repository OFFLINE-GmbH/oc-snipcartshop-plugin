<?php

namespace OFFLINE\SnipcartShop\Classes;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * This class communicates with the Snipcart api
 * to read, create, update and delete discounts.
 *
 * @package OFFLINE\SnipcartShop\Classes
 */
class DiscountService
{
    /**
     * Snipcart API base uri
     * @var string
     */
    const BASE_URI = 'https://app.snipcart.com/api/discounts';
    /**
     * Guzzle Http Client
     * @var Client
     */
    private $http;

    public function __construct($apiKey, Client $http = null)
    {
        $this->apiKey = $apiKey;
        $this->http   = $http ?: new Client([
            'base_uri' => self::BASE_URI,
            'timeout'  => 5.0,
            'auth'     => [$apiKey, ''] // Second parameter (password) must be empty
        ]);
    }

    /**
     * Returns a list of all available discounts.
     *
     * @return Collection
     */
    public function get()
    {
        $response = $this->http->get('/');

        dd($response);
    }
}