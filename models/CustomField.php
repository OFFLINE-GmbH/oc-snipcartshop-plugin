<?php namespace OFFLINE\SnipcartShop\Models;

use Model;

/**
 * CustomField Model
 */
class CustomField extends Model
{
    use \October\Rain\Database\Traits\Validation;


    public $table = 'offline_snipcartshop_product_custom_fields';
    public $timestamps = true;
    public $jsonable = ['options'];

    public $rules = [
        'product_id' => 'exists:offline_snipcartshop_products,id',
        'name'       => 'required',
        'type'       => 'in:text,textarea,dropdown',
        'required'   => 'boolean',
    ];

    public $belongsTo = [
        'product' => 'OFFLINE\SnipcartShop\Models\Product',
    ];

    public $belongsToMany = [
        'variants' => [
            'OFFLINE\SnipcartShop\Models\Variant',
            'table'    => 'offline_snipcartshop_product_variant_custom_field',
            'key'      => 'custom_field_id',
            'otherKey' => 'variant_id',
        ],
    ];
}