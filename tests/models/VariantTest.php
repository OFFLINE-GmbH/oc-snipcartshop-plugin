<?php namespace OFFLINE\SnipcartShop\Tests\Models;

use OFFLINE\SnipcartShop\Models\CustomField;
use OFFLINE\SnipcartShop\Models\Product;
use OFFLINE\SnipcartShop\Models\Variant;
use PluginTestCase;

class VariantTest extends PluginTestCase
{
    public function test_custom_field_relationship()
    {
        $product        = new Product();
        $product->name  = 'Test';
        $product->price = 20;
        $product->save();

        $field1 = $this->createCustomField($product);
        $field2 = $this->createCustomField($product);

        $variant             = new Variant();
        $variant->product_id = $product->id;
        $variant->stock      = 40;
        $variant->save();

        $variant->custom_fields()->sync([$field1->id => ['option' => 'X'], $field2->id => ['option' => 'Y']]);

        $this->assertCount(2, $variant->fresh()->custom_fields()->get());
    }

    protected function createCustomField($product)
    {
        $field             = new CustomField();
        $field->name       = 'Test';
        $field->type       = 'text';
        $field->product_id = $product->id;
        $field->save();

        return $field;
    }
}