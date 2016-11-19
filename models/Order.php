<?php namespace OFFLINE\SnipcartShop\Models;

use Model;
use OFFLINE\SnipcartShop\Classes\MoneyFormatter;

/**
 * Model
 */
class Order extends Model
{

    use MoneyFormatter;

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
        return $this->formatMoney($this->grand_total);
    }

    public function getSubtotalFormattedAttribute()
    {
        return $this->formatMoney($this->subtotal);
    }

    public function getShippingFeesFormattedAttribute()
    {
        return $this->formatMoney($this->shipping_fees);
    }
}