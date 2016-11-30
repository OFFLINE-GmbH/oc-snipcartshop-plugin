<?php namespace OFFLINE\SnipcartShop\Models;

use Model;

/**
 * Model
 */
class Discount extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'name'                 => 'required',
        'expires'              => 'date',
        'max_number_of_usages' => 'numeric',
        'trigger'              => 'in:total,code,product',
        'types'                => 'in:fixed_amount,rate,alternate_price,shipping',
        'code'                 => 'required_if:trigger,code',
        'total_to_reach'       => 'required_if:trigger,total|numeric',
        // The field's name is item_id but the relation's name is product.
        // October currently doesn't support alternative names for relation
        // form widgets, that's why we have  we leave this validation
        // out until a fix is found.
        // 'product'              => 'required_if:trigger,product',
        'type'                 => 'in:fixed_amount,rate,alternate_price,shipping',
        'amount'               => 'required_if:type,fixed_amount|numeric',
        'rate'                 => 'required_if:type,rate|numeric',
        'alternate_price'      => 'required_if:type,alternate_price|numeric',
        'shipping_description' => 'required_if:type,shipping',
        'shipping_cost'        => 'required_if:type,shipping|numeric',
        'shipping_guaranteed_days_to_delivery'  => 'numeric',
    ];

    public $belongsTo = [
        'product' => [
            'OFFLINE\SnipcartShop\Models\Product',
            'key' => 'id',
            'otherKey' => 'item_id',
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'offline_snipcartshop_discounts';

    public function getTypeOptions()
    {
        return trans('offline.snipcartshop::lang.plugin.discounts.types');
    }

    public function getTriggerOptions()
    {
        return trans('offline.snipcartshop::lang.plugin.discounts.triggers');
    }
}