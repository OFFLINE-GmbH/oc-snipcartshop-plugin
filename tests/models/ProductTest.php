<?php namespace OFFLINE\SnipcartShop\Tests\Models;

use OFFLINE\SnipcartShop\Models\CustomField;
use OFFLINE\SnipcartShop\Models\Product;
use PluginTestCase;

class ProductTest extends PluginTestCase
{
    public function test_it_casts_the_price_to_json()
    {
        $price = [
            ['currency' => 'CHF', 'price' => 1000],
            ['currency' => 'USD', 'price' => 1000],
        ];

        $product        = new Product();
        $product->name  = 'Test';
        $product->slug  = 'test';
        $product->price = $price;
        $product->save();

        $db = \DB::table($product->table)->where('id', $product->id)->first();

        $this->assertEquals(json_encode($price), $db->price);
        $this->assertEquals($price, $product->fresh()->price);
    }

    public function test_custom_field_relationship()
    {
        $product = $this->getProduct();

        $field             = new CustomField();
        $field->product_id = $product->id;
        $field->name       = 'Test';
        $field->type       = 'text';
        $field->required   = true;

        $product->custom_fields()->save($field);

        $this->assertEquals('Test', $product->fresh()->custom_fields->first()->name);
    }

    /**
     * @return Product
     */
    protected function getProduct()
    {
        $product        = new Product();
        $product->name  = 'Test';
        $product->slug  = 'test';
        $product->price = 20;
        $product->save();

        return $product;
    }

    /**
     * @param $product
     *
     * @return CustomField
     */
    protected function createCustomFieldForProduct($name, $product)
    {
        $field             = new CustomField();
        $field->product_id = $product->id;
        $field->name       = $name;
        $field->type       = 'dropdown';
        $field->options    = [['name' => 'Test'], ['name' => 'Test2']];

        return $field;
    }
}