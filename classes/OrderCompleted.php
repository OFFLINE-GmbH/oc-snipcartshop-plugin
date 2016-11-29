<?php

namespace OFFLINE\SnipcartShop\Classes;

use Carbon\Carbon;
use Event;
use OFFLINE\SnipcartShop\Models\Order;
use OFFLINE\SnipcartShop\Models\OrderItem;

class OrderCompleted
{
    protected $ignoreFieldsOrder = [
        'items', // Temporary

        'discounts',
        'plans',
        'refunds',
        'taxesTotal',
        'user',
        'totalNumberOfItems',
        'numberOfItemsInOrder',
        'itemsCount',
        'summary',
        'customFieldsJson',
        'shippingMethodComplete',
        'finalGrandTotal',
        'total',

        // Included via jsonable billingAddress
        'billingAddressFirstName',
        'billingAddressName',
        'billingAddressCompanyName',
        'billingAddressAddress1',
        'billingAddressAddress2',
        'billingAddressCity',
        'billingAddressCountry',
        'billingAddressProvince',
        'billingAddressPostalCode',
        'billingAddressPhone',
        'billingAddressComplete',
        // Included via jsonable shippingAddress
        'shippingAddressFirstName',
        'shippingAddressName',
        'shippingAddressCompanyName',
        'shippingAddressAddress1',
        'shippingAddressAddress2',
        'shippingAddressCity',
        'shippingAddressCountry',
        'shippingAddressProvince',
        'shippingAddressPostalCode',
        'shippingAddressPhone',
        'shippingAddressComplete',
    ];

    protected $ignoreFieldsItem = [
        'token',
        'unitPrice',
        'modificationDate',
        'maxQuantity',
        'minQuantity',
        'originalPrice',
        'initialData',
        'alternatePrices',
        'hasDimensions',
    ];

    public function handle($data)
    {
        $itemsData = $data['items'];
        $orderData = $this->normalizeData($data, $this->ignoreFieldsOrder);

        $order = Order::firstOrCreate(['token' => $orderData['token']]);
        $order->fill($orderData);
        $order->save();

        $items = [];
        foreach ($itemsData as $item) {
            $data               = $this->normalizeData($item, $this->ignoreFieldsItem);
            $data['product_id'] = $item['id'];

            $model = new OrderItem();
            $model->fill($data);

            $items[] = $model;
        }

        // Remove existing items from this order to prevent
        // duplicate items if the webhook is sent a second time
        $order->items()->delete();
        $order->items()->saveMany($items);

        Event::fire('snipcartshop.order.created', $order);
    }

    /**
     * Strip out ignored fields and convert all keys
     * to snake_case.
     *
     * @param $data
     *
     * @return array
     */
    protected function normalizeData($data, $ignoredFields)
    {
        $normalized = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $ignoredFields)) {
                continue;
            }

            $normalized[snake_case($key)] = $value;
        }

        return $this->reformatDates($normalized);
    }

    /**
     * Convert the Snipcart date format to a standard carbon instance.
     *
     * @param $data
     *
     * @return mixed
     */
    protected function reformatDates($data)
    {
        foreach (['creation_date', 'modification_date', 'completion_date'] as $date) {
            if ( ! array_key_exists($date, $data)) {
                continue;
            }
            $data[$date] = Carbon::createFromFormat('Y-m-d\TH:i:s\.u\Z', $data[$date]);
        }

        return $data;
    }
}