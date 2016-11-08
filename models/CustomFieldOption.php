<?php namespace OFFLINE\SnipcartShop\Models;

use Model;

/**
 * CustomFieldOption Model
 */
class CustomFieldOption extends Model
{
    use \October\Rain\Database\Traits\Validation;


    public $table = 'offline_snipcartshop_product_custom_field_options';
    public $timestamps = true;

    public $fillable = [
        'id',
        'name',
        'price',
        'sort_order',
    ];

    public $rules = [
        'name'  => 'required',
        'price' => 'numeric',
    ];

    public $belongsTo = [
        'product' => 'OFFLINE\SnipcartShop\Models\Product',
        'custom_field' => 'OFFLINE\SnipcartShop\Models\CustomField',
    ];

    public $belongsToMany = [
        'variants' => [
            'OFFLINE\SnipcartShop\Models\Variant',
            'table'    => 'offline_snipcartshop_product_variant_custom_field_option',
            'key'      => 'custom_field_option_id',
            'otherKey' => 'variant_id',
        ],
    ];
}