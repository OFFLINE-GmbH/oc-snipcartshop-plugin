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
    public $jsonable = ['billing_address', 'shipping_address', 'custom_fields', 'metadata', 'taxes'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'offline_snipcartshop_orders';

    public $hasMany = [
        'items' => 'OFFLINE\SnipcartShop\Models\OrderItem',
    ];

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