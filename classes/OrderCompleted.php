<?php

namespace OFFLINE\SnipcartShop\Classes;

use Carbon\Carbon;
use Event;
use OFFLINE\SnipcartShop\Models\Order;
use OFFLINE\SnipcartShop\Models\OrderItem;

class OrderCompleted
{
    protected $orderFields = [
        'token',
        'invoiceNumber',
        'currency',
        'creationDate',
        'modificationDate',
        'completionDate',
        'status',
        'paymentStatus',
        'email',
        'willBePaidLater',
        'shippingAddressSameAsBilling',
        'billingAddress',
        'shippingAddress',
        'creditCardLast4Digits',
        'trackingNumber',
        'trackingUrl',
        'shippingMethod',
        'cardHolderName',
        'cardType',
        'paymentMethod',
        'paymentGatewayUsed',
        'taxProvider',
        'lang',
        'refundsAmount',
        'adjustedAmount',
        'rebateAmount',
        'taxes',
        'itemsTotal',
        'subtotal',
        'taxableTotal',
        'grandTotal',
        'totalWeight',
        'totalRebateRate',
        'notes',
        'customFields',
        'shippingEnabled',
        'paymentTransactionId',
        'metadata',
        'ipAddress',
        'userId',
        'discounts'
    ];

    protected $itemFields = [
        'uniqueId',
        'orderId',
        'name',
        'price',
        'totalPrice',
        'quantity',
        'maxQuantity',
        'url',
        'weight',
        'width',
        'length',
        'height',
        'totalWeight',
        'description',
        'image',
        'stackable',
        'duplicatable',
        'shippable',
        'taxable',
        'customFields',
        'taxes',
        'addedOn',
    ];

    public function handle($data)
    {
        $itemsData = $data['items'];
        $orderData = $this->normalizeData($data, $this->orderFields);

        $order = Order::firstOrCreate(['token' => $orderData['token']]);
        $order->fill($orderData);
        $order->save();

        $items = [];
        foreach ($itemsData as $item) {
            $data               = $this->normalizeData($item, $this->itemFields);
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
     * Select relveant fields and convert all keys
     * to snake_case.
     *
     * @param $data
     * @param $useFields
     *
     * @return array
     */
    protected function normalizeData($data, array $useFields)
    {
        $normalized = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $useFields)) {
                $normalized[snake_case($key)] = $value;
            }
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
        foreach (['creation_date', 'modification_date', 'completion_date', 'added_on'] as $date) {
            if ( ! array_key_exists($date, $data)) {
                continue;
            }
            $data[$date] = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $data[$date]);
        }

        return $data;
    }
}