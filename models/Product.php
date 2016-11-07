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

    /**
     * If only a single currency is configured, we
     * replace the currency repeater with a simple number input.
     * We will add the default currency code in the beforeSave method.
     *
     * @see $this->beforeSave();
     */
    public function filterFields($fields)
    {
        $currencies = Settings::currencies();
        if (count($currencies) <= 1) {
            $fields->price->type = 'number';
            $fields->price->span = 'left';

            if (is_array($this->price)) {
                // Since we use a single number input we have to parse the price
                // out of the array value that is stored in the price field.
                $fields->price->value = array_values($this->price)[0]['price'];
            }
        }
    }

    /**
     * If only a single currency is configured we need to transform
     * the simple number input back to an array with a currency code.
     *
     * @see $this->filterFields()
     */
    public function beforeSave()
    {
        if (count($this->price) > 0) {
            // Since the price field is jsonable we'll get back
            // an array with only a single number if just one currency
            // is configured. In this is the case we need to transform
            // it to an array and add the currency code.
            $price = array_values($this->price)[0];
            if ( ! is_array($price)) {
                $this->price = [['currency' => Settings::currencies()->first(), 'price' => $price]];
            }
        }
    }

    public function getCurrencyOptions()
    {
        return Settings::currencies();
    }

    public function getVariantOptionsAttribute()
    {
        return $this->custom_fields()->where('type', 'dropdown')->get();
    }
}