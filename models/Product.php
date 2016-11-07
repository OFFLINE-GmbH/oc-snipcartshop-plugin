<?php namespace OFFLINE\SnipcartShop\Models;

use Model;

/**
 * CustomField Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'offline_snipcartshop_products';
    public $timestamps = true;
    public $jsonable = ['price'];

    public $rules = [
        'name'  => 'required',
        'price' => 'required',
    ];

    public $hasMany = [
        'custom_fields' => 'OFFLINE\SnipcartShop\Models\CustomField',
        'variants'      => 'OFFLINE\SnipcartShop\Models\Variant',
    ];

    public $attachOne = [
        'main_image' => 'System\Models\File',
    ];

    public $attachMany = [
        'images'    => 'System\Models\File',
        'downloads' => 'System\Models\File',
    ];

    public $hasManyThrough = [
        'custom_field_options' => [
            'OFFLINE\SnipcartShop\Models\CustomFieldOption',
            'key'        => 'product_id',
            'through'    => 'OFFLINE\SnipcartShop\Models\Variant',
            'throughKey' => 'custom_field_id',
        ],
    ];

    public function getVariantOptionsAttribute()
    {
        return $this->custom_fields()->where('type', 'dropdown')->get();
    }
}