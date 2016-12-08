<?php namespace OFFLINE\SnipcartShop\Models;

use Model;

/**
 * Model
 */
class OrderItem extends Model
{
    /**
     * Format of all $dates.
     * @var string
     */
    protected $dateFormat = 'Y-m-d\TH:i:s\.u\Z';

    public $timestamps = false;
    public $guarded = ['id'];
    public $dates = ['added_on'];
    public $jsonable = ['custom_fields', 'taxes'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'offline_snipcartshop_order_items';

    public $belongsTo = [
        'order' => 'OFFLINE\SnipcartShop\Models\Order',
    ];

    public function getPriceFormattedAttribute()
    {
        return format_money($this->price);
    }

    public function getTotalPriceFormattedAttribute()
    {
        return format_money($this->total_price);
    }
}