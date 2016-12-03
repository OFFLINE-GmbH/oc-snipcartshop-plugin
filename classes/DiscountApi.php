<?php

namespace OFFLINE\SnipcartShop\Classes;

use GuzzleHttp\Client;
use October\Rain\Exception\ValidationException;
use OFFLINE\SnipcartShop\Models\Discount;
use OFFLINE\SnipcartShop\Models\ApiSettings;

/**
 * This class communicates with the Snipcart api
 * to read, create, update and delete discounts.
 *
 * @package OFFLINE\SnipcartShop\Classes
 */
class DiscountApi
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

    public function __construct($apiKey = null, Client $http = null)
    {
        $this->apiKey = $apiKey ?: ApiSettings::get('private_api_key');
        $this->http   = $http ?: new Client([
            'base_uri' => self::BASE_URI,
            'headers'  => ['Accept' => 'application/json'],
            'auth'     => [$this->apiKey, ''], // Second parameter (password) has to be empty
        ]);
    }

    /**
     * Returns a list of all available discounts.
     */
    public function updateDiscountUsages()
    {
        try {
            $response = $this->http->get('');
            if ($response->getStatusCode() >= 400) {
                // Gets catched below
                throw new \RuntimeException((string)$response->getBody());
            }

            $json = json_decode((string)$response->getBody());
            foreach ($json as $discount) {
                Discount::updateUsageStats($discount);
            }
        } catch (\Exception $e) {
            \Log::error('[snipcartshop] Failed to create discount.', ['exception' => $e]);
            throw new ValidationException([trans('offline.snipcartshop::lang.plugin.discounts.api_error')]);
        }
    }

    /**
     * Creates a new discount.
     */
    public function create(Discount $discount)
    {
        try {
            $response = $this->http->post('', ['json' => $discount->requestData()]);
            if ($response->getStatusCode() >= 400) {
                // Gets catched below
                throw new \RuntimeException((string)$response->getBody());
            }

            $json           = json_decode((string)$response->getBody());
            $discount->guid = $json->id;

            return $discount;
        } catch (\Exception $e) {
            \Log::error('[snipcartshop] Failed to create discount.', ['exception' => $e]);
            throw new ValidationException([trans('offline.snipcartshop::lang.plugin.discounts.api_error')]);
        }
    }

    /**
     * Updates an existing discount.
     */
    public function update(Discount $discount)
    {
        try {
            $response = $this->http->put('discounts/' . $discount->guid, ['json' => $discount->requestData()]);
            if ($response->getStatusCode() >= 400) {
                // Gets catched below
                throw new \RuntimeException();
            }

            return $discount;
        } catch (\Exception $e) {
            \Log::error('[snipcartshop] Failed to update discount.', ['exception' => $e]);
            throw new ValidationException([trans('offline.snipcartshop::lang.plugin.discounts.api_error')]);
        }
    }

    /**
     * Deletes an existing discount.
     */
    public function destroy(Discount $discount)
    {
        try {
            $response = $this->http->delete('discounts/' . $discount->guid);
            if ($response->getStatusCode() >= 400) {
                // Gets catched below
                throw new \RuntimeException();
            }

            return $discount;
        } catch (\Exception $e) {
            \Log::error('[snipcartshop] Failed to delete discount.', ['exception' => $e]);
            throw new ValidationException([trans('offline.snipcartshop::lang.plugin.discounts.api_error')]);
        }
    }
}