<?php

namespace OFFLINE\SnipcartShop\Classes;


use Cms\Classes\Controller;
use OFFLINE\SnipcartShop\Models\GeneralSettings;
use OFFLINE\SnipcartShop\Models\Product;

class DataAttributes
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @var array
     */
    protected $attributes = [];

    public function __construct(Product $product, GeneralSettings $settings = null)
    {
        $this->product  = $product;
        $this->settings = $settings ?: new GeneralSettings();

        $this->generate();
    }

    public function attributes()
    {
        return $this->attributes;
    }

    protected function generate()
    {
        $this->baseData();
        $this->description();
        $this->image();
        $this->shippingProperties();
        $this->quantities();
        $this->price();
        $this->taxes();
        $this->url();
        $this->customFields();

        return $this->attributes;
    }

    protected function baseData()
    {
        $this->applyAttribute('id');
        $this->applyAttribute('name');
    }

    protected function description()
    {
        $this->setAttribute('description', $this->product->description_short);
    }

    protected function image()
    {
        if ($this->product->image) {
            $this->setAttribute('image', url($this->product->image->getThumb(50, 50, 'crop')));
        }
    }

    protected function shippingProperties()
    {
        $this->applyAttribute('weight');
        $this->applyAttribute('width');
        $this->applyAttribute('length');
        $this->applyAttribute('height');
        $this->setAttribute('shippable', $this->product->shippable ? 'true' : 'false');
    }

    protected function quantities()
    {
        $default = $this->product->quantity_default;
        if ($default !== null) {
            $this->setAttribute('quantity', (int)$default);
        }

        $min = $this->product->quantity_min;
        if ($min !== null) {
            $this->setAttribute('min-quantity', (int)$min);
        }

        $max = $this->product->quantity_max;
        if ($max !== null) {
            $this->setAttribute('max-quantity', (int)$max);
        }
    }

    protected function price()
    {
        $price = $this->product->price;

        if (count($price) === 1) {
            // Single currency
            $price = array_values($price)[0]['price'];
        } else {
            $price = [];
            foreach ($this->product->price as $entry) {
                $price[$entry['currency']] = (float)$entry['price'];
            }
        }

        $this->setAttribute('price', $price);
    }

    protected function taxes()
    {
        $this->setAttribute('taxable', $this->product->taxable ? 'true' : 'false');
    }

    protected function url()
    {
        $controller = new Controller();

        $slug = $this->settings->get('product_page_slug', 'slug');
        // The setting was saved empty (use default)
        if ($slug === '') {
            $slug = 'slug';
        }

        if ( ! $this->settings->get('product_page')) {
            throw new \InvalidArgumentException(
                'SnipcartShop: Please select a product page via the backend settings.'
            );
        }

        $url = $controller->pageUrl(
            $this->settings->get('product_page'),
            [$slug => $this->product->slug]
        );

        $this->setAttribute('url', $url);
    }

    protected function customFields()
    {
        $fields = $this->product->custom_fields()->with('options')->get()->map(function ($field) {
            $key = 'custom' . $field->id;
            $set = [
                $key . '-name'     => $field->name,
                $key . '-required' => $field->required ? 'true' : 'false',
            ];

            if ($field->type === 'textarea') {
                $set[$key . '-type'] = 'textarea';
            }

            if ($options = $field->dataAttributeString) {
                $set[$key . '-options'] = $options;
            }

            return collect($set);
        });

        $fields->each(function ($field) {
            $field->each(function ($value, $name) {
                $this->setAttribute($name, $value);
            });
        });
    }

    /**
     * Copies a attribute of $product into $attributes.
     *
     * @param $attribute
     *
     * @return DataAttributes
     */
    protected function applyAttribute($attribute)
    {
        $value = $this->product->{$attribute};
        if ($value === '' || $value === null) {
            return $this;
        }

        return $this->setAttribute($attribute, $value);
    }

    /**
     * Sets an attribute on the attributes array.
     *
     * @param $name
     * @param $value
     *
     * @return $this
     */
    protected function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Returns the attributes as html string.
     *
     * @return string
     */
    public function __toString()
    {
        $attributes = [];
        foreach ($this->attributes as $key => $value) {
            // Make sure to transform arrays to json and esacpe the
            // output accordingly so we don't mess up the markup
            $value = is_array($value) ? json_encode($value) : e($value);

            $attributes[] = sprintf("data-item-%s='%s'", $key, $value);
        }

        return implode(" ", $attributes);
    }
}