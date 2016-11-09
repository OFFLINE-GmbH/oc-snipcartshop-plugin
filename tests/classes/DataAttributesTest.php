<?php namespace OFFLINE\SnipcartShop\Tests\Models;


use OFFLINE\SnipcartShop\Classes\DataAttributes;
use OFFLINE\SnipcartShop\Models\Product;
use PluginTestCase;

class DataAttributesTest extends PluginTestCase
{
    public function test_base_attributes()
    {
        $product = $this->getProduct();

        $attr = new DataAttributes($product);

        $generated = $attr->attributes();

        $this->assertEquals($generated['id'], $product->id);
        $this->assertEquals($generated['name'], $product->name);
        $this->assertEquals($generated['description'], $product->description);
    }

    public function test_price_single()
    {
        $product = $this->getProduct();
        $product->price = [['currency' => 'CHF', 'price' => 200]];

        $attr = new DataAttributes($product);
        $generated = $attr->attributes();

        $this->assertEquals($generated['price'], 200);
    }

    protected function getProduct()
    {
        $product              = new Product();
        $product->name        = 'Test';
        $product->slug        = 'test';
        $product->price       = [
            ['currency' => 'CHF', 'price' => 200],
            ['currency' => 'USD', 'price' => 202],
        ];
        $product->description = 'Description';

        $product->save();

        return $product;
    }
}