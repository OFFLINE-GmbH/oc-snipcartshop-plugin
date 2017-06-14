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

    // Repeater fields are currently not translatable
    // @see https://github.com/rainlab/translate-plugin/issues/190
    // public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];
    // public $translatable = ['name'];

    public $fillable = [
        'id',
        'name',
        'price',
        'sort_order',
        'custom_field_id'
    ];

    public $rules = [
        'name' => 'required',
        'price' => 'regex:/\d+([\.,]\d+)?/i',
    ];

    public $belongsTo = [
        'product'      => 'OFFLINE\SnipcartShop\Models\Product',
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

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value * 100;
    }

    public function getPriceAttribute($value)
    {
        return $this->formatPrice((integer)$value / 100);
    }

    public function formatPrice($price)
    {
        return number_format($price, 2, '.', '');
    }

    public function getDataAttributeStringAttribute()
    {
        $string = $this->name;

        if ($this->price) {
            $string .= sprintf("[+%s]", $this->formatPrice($this->price));
        }

        return $string;
    }
}