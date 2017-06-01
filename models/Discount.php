<?php namespace OFFLINE\SnipcartShop\Models;

use Model;
use OFFLINE\SnipcartShop\Classes\DiscountApi;

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
        'name'                                 => 'required',
        'expires'                              => 'date',
        'max_number_of_usages'                 => 'numeric',
        'trigger'                              => 'in:total,code,product',
        'types'                                => 'in:fixed_amount,rate,alternate_price,shipping',
        'code'                                 => 'required_if:trigger,code',
        'total_to_reach'                       => 'required_if:trigger,total|numeric',
        'product'                              => 'required_if:trigger,product',
        'type'                                 => 'in:fixed_amount,rate,alternate_price,shipping',
        'amount'                               => 'required_if:type,fixed_amount|numeric',
        'rate'                                 => 'required_if:type,rate|numeric',
        'alternate_price'                      => 'required_if:type,alternate_price|numeric',
        'shipping_description'                 => 'required_if:type,shipping',
        'shipping_cost'                        => 'required_if:type,shipping|numeric',
        'shipping_guaranteed_days_to_delivery' => 'numeric',
    ];

    public $belongsTo = [
        'product' => [
            'OFFLINE\SnipcartShop\Models\Product',
        ],
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'offline_snipcartshop_discounts';

    public static function boot()
    {
        parent::boot();

        $api = new DiscountApi();

        static::updating(function (Discount $discount) use ($api) {
            return $api->update($discount);
        });
        static::creating(function (Discount $discount) use ($api) {
            return $api->create($discount);
        });
        static::deleting(function (Discount $discount) use ($api) {
            return $api->destroy($discount);
        });
    }

    public static function updateUsageStats($discount)
    {
        Discount::where('guid', $discount->id)->update([
            'number_of_usages'             => $discount->numberOfUsages,
            'number_of_usages_uncompleted' => $discount->numberOfUsagesUncompleted,
        ]);
    }

    public function getTypeOptions()
    {
        return trans('offline.snipcartshop::lang.plugin.discounts.types');
    }

    public function getTriggerOptions()
    {
        return trans('offline.snipcartshop::lang.plugin.discounts.triggers');
    }

    /**
     * This method returns all attributes as array
     * with camel_case'd keys. This is needed for the
     * Discount API call.
     *
     * @return mixed
     */
    public function requestData()
    {
        $data = $this->removeNullValues([
            'id'                               => $this->guid,
            'name'                             => $this->name,
            'code'                             => $this->code,
            'itemId'                           => $this->product_id,
            'totalToReach'                     => $this->total_to_reach,
            'type'                             => studly_case($this->type),
            'trigger'                          => studly_case($this->trigger),
            'rate'                             => $this->rate,
            'amount'                           => $this->amount,
            'alternatePrice'                   => $this->alternate_price,
            'maxNumberOfUsages'                => $this->max_number_of_usages,
            'expires'                          => $this->expires,
            'shippingDescription'              => $this->shipping_description,
            'shippingCost'                     => $this->shipping_cost,
            'shippingGuaranteedDaysToDelivery' => $this->shipping_guaranteed_days_to_delivery,
        ]);

        // Because of a bug on Snipcart's side we need to remove any
        // itemId from the request if the trigger type is not set to product.
        // If any itemId is sent along the trigger type will be ignored and
        // the coupon will be applied as soon as this product will be added to
        // the cart.
        if($this->trigger !== 'product') {
            $data['itemId'] = null;
        }

        return $data;
    }

    /**
     * Removes all null and empty values from an array.
     *
     * @param array $input
     *
     * @return array
     */
    private function removeNullValues(array $input)
    {
        return array_filter($input, function ($item) {
            return $item !== null && $item !== '';
        });
    }
}