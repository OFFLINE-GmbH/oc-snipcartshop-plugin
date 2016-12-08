<?php

namespace OFFLINE\SnipcartShop\Classes;

use October\Rain\Exception\ValidationException;
use OFFLINE\SnipcartShop\Models\Order;

/**
 * This class communicates with the Snipcart api
 * to update existing orders.
 *
 * @package OFFLINE\SnipcartShop\Classes
 */
class OrderApi extends Api
{
    /**
     * Updates an existing order.
     *
     * @param Order $order
     *
     * @return mixed
     * @throws ValidationException
     */
    public function update(Order $order)
    {
        try {
            $response = $this->http->put('orders/' . $order->token, ['json' => $order->requestData()]);
            if ($response->getStatusCode() >= 400) {
                // Gets catched below
                throw new \RuntimeException();
            }

            return $order;
        } catch (\Exception $e) {
            \Log::error('[snipcartshop] Failed to update order.', ['exception' => $e]);
            throw new ValidationException([trans('offline.snipcartshop::lang.plugin.common.api_error')]);
        }
    }
}