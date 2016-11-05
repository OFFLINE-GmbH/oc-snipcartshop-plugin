<?php namespace OFFLINE\SnipcartShop\Tests\Models;

use OFFLINE\SnipcartShop\Models\CustomField;
use OFFLINE\SnipcartShop\Models\Product;
use OFFLINE\SnipcartShop\Models\Variant;
use PluginTestCase;

class CustomFieldTest extends PluginTestCase
{
    public function test_it_casts_the_options_to_json()
    {
        $product        = new Product();
        $product->name  = 'Test';
        $product->price = 20;
        $product->save();

        $options = [
            ['name' => '32GB', 'price' => 20],
            ['name' => '32GB', 'price' => 40],
        ];

        $field             = new CustomField();
        $field->name       = 'Test';
        $field->options    = $options;
        $field->product_id = $product->id;
        $field->type       = 'dropdown';
        $field->required   = true;
        $field->save();

        $db = \DB::table($field->table)->where('id', $field->id)->first();

        $this->assertEquals(json_encode($options), $db->options);
        $this->assertEquals($options, $field->fresh()->options);
    }
}