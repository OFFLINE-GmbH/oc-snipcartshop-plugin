<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOfflineSnipcartshopProductVariantCustomField extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_product_variant_custom_field', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('variant_id')->unsigned();
            $table->integer('custom_field_id')->unsigned();
            $table->string('option');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_product_variant_custom_field');
    }
}
