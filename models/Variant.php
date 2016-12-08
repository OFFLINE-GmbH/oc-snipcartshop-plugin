<?php namespace OFFLINE\SnipcartShop\Models;

use Model;

/**
 * Variant Model
 */
class Variant extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'offline_snipcartshop_product_variants';
    public $timestamps = true;

    public $rules = [
        'product_id'                   => 'required|exists:offline_snipcartshop_products,id',
        'stock'                        => 'integer',
        'allow_out_of_stock_purchases' => 'boolean',
    ];

    public $belongsTo = [
        'product' => 'OFFLINE\SnipcartShop\Models\Product',
    ];

    public $belongsToMany = [
        'custom_field_options' => [
            'OFFLINE\SnipcartShop\Models\CustomFieldOption',
            'table'    => 'offline_snipcartshop_product_variant_custom_field_option',
            'key'      => 'variant_id',
            'otherKey' => 'custom_field_option_id',
        ],
    ];

}