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
}