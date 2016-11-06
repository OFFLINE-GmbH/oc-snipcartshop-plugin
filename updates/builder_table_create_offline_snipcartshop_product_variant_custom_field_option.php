<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOfflineSnipcartshopProductVariantCustomFieldOption extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_product_variant_custom_field_option', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('variant_id')->unsigned();
            $table->integer('custom_field_option_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_product_variant_custom_field_option');
    }
}
