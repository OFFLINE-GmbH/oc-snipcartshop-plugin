<?php namespace OFFLINE\SnipcartShop\Models;

use Illuminate\Database\Eloquent\Collection;
use Model;
use OFFLINE\SnipcartShop\Classes\DataAttributes;
use OFFLINE\SnipcartShop\Classes\MoneyFormatter;
use System\Models\File;

/**
 * CustomField Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation, MoneyFormatter;

    public $table = 'offline_snipcartshop_products';
    public $timestamps = true;
    public $jsonable = ['price'];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'name',
        ['slug', 'index' => true],
        'description_short',
        'description',
        'meta_title',
        'meta_description',
    ];

    public $rules = [
        'name'  => 'required',
        'slug'  => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:offline_snipcartshop_products'],
        'price' => 'required',
    ];

    public $hasMany = [
        'custom_fields' => 'OFFLINE\SnipcartShop\Models\CustomField',
        'variants'      => 'OFFLINE\SnipcartShop\Models\Variant',
    ];

    public $belongsTo = [
        'discount' => 'OFFLINE\SnipcartShop\Models\Discount',
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

    public $belongsToMany = [
        'categories' => [
            'OFFLINE\SnipcartShop\Models\Category',
            'table'    => 'offline_snipcartshop_category_product',
            'key'      => 'product_id',
            'otherKey' => 'category_id',
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
        $currencies = CurrencySettings::currencies();
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
            if ( ! is_array($this->price)) {
                $this->price = [$this->price];
            }

            // Since the price field is jsonable we'll get back
            // an array with only a single number if just one currency
            // is configured. In this is the case we need to transform
            // it to an array and add the currency code.
            $price = array_values($this->price)[0];
            if ( ! is_array($price)) {
                $this->price = [['currency' => CurrencySettings::currencies()->first(), 'price' => $price]];
            }
        }
    }

    /**
     * Return the main image, if one is uploaded. Otherwise
     * use the first available image.
     *
     * @return File
     */
    public function getImageAttribute()
    {
        if ($this->main_image) {
            return $this->main_image;
        }

        if ($this->images) {
            return $this->images->first();
        }
    }

    /**
     * Return all images except the main image.
     *
     * @return Collection
     */
    public function getAdditionalImagesAttribute()
    {
        // If a main image exists for this product we
        // can just return all additional images.
        if ($this->main_image) {
            return $this->images;
        }

        // If no main image is uploaded we have to exclude the
        // alternatively selected main image form the collection.
        $mainImage = $this->image;

        return $this->images->reject(function ($item) use ($mainImage) {
            return $item->id === $mainImage->id;
        });
    }

    /**
     * This method returns all data-* attribute sneeded
     * for the snipcart checkout button.
     *
     * @return DataAttributes
     */
    public function getDataAttributesAttribute()
    {
        return new DataAttributes($this);
    }

    public function getVariantOptionsAttribute()
    {
        return $this->custom_fields()->where('type', 'dropdown')->get();
    }

    /**
     * Returns the price in the currently active currency
     * formatted as string.
     *
     * @throws \RuntimeException
     * @return string
     */
    public function getPriceFormattedAttribute()
    {
        $activeCurrency = CurrencySettings::activeCurrency();
        $currency       = collect($this->price)
            ->where('currency', $activeCurrency)
            ->first();

        return $this->formatMoney($currency['price'], $activeCurrency);
    }

    public function getCurrencyOptions()
    {
        return CurrencySettings::currencies();
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}