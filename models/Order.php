<?php namespace OFFLINE\SnipcartShop\Models;

use Model;

/**
 * Model
 */
class Order extends Model
{

    public $timestamps = false;
    public $guarded = ['id'];
    public $dates = ['creation_date', 'modification_date', 'completion_date'];
    public $jsonable = ['billing_address', 'shipping_address', 'custom_fields', 'metadata', 'taxes', 'discounts'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'offline_snipcartshop_orders';

    public $hasMany = [
        'items' => 'OFFLINE\SnipcartShop\Models\OrderItem',
    ];

    /**
     * This method is used to provide the data for the
     * api call to update the order's status.
     *
     * @return array
     */
    public function requestData()
    {
        return [
            'status'         => studly_case($this->status),
            'paymentStatus'  => studly_case($this->payment_status),
            'trackingNumber' => $this->tracking_number,
            'trackingUrl'    => $this->tracking_url,
        ];
    }

    public static function scopeStatus()
    {
        return ['a', 'b'];
    }

    public function getDiscountCodes()
    {
        return collect($this->discounts)->pluck('code')->implode(', ');
    }

    public function getCreationDateFormattedAttribute()
    {
        return $this->creation_date->format('d.m.Y H:i:s');
    }

    public function getGrandTotalFormattedAttribute()
    {
        return format_money($this->grand_total);
    }

    public function getSubtotalFormattedAttribute()
    {
        return format_money($this->subtotal);
    }

    public function getShippingFeesFormattedAttribute()
    {
        return format_money($this->shipping_fees);
    }

    /**
     * Returns an array as comma separated values.
     *
     * @param array $input
     *
     * @return string
     */
    public function commaSeparated(array $input)
    {
        return collect($input)->reject(function ($entry) {
            return ! $entry;
        })->implode(', ');
    }

    /**
     * Returns an array as key/comma separated values.
     *
     * @param array $input
     *
     * @return string
     */
    public function commaSeparatedWithKeys($input)
    {
        $entries = collect($input)->reject(function ($entry) {
            return ! $entry;
        });

        return $this->mapWithKeys($entries)->flatMap(function ($i) {
            return $i;
        })->implode(', ');
    }

    protected function mapWithKeys($entries)
    {
        return collect($entries)->map(function ($value, $key) {
            if (is_array($value)) {
                return $this->mapWithKeys($value);
            }

            return $value ? $key . ': ' . $value : false;
        })->values()->reject(function ($value) {
            return $value === false;
        });
    }
}