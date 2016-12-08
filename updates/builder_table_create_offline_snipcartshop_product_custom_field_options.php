<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOfflineSnipcartshopProductCustomFieldOptions extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_product_custom_field_options', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('custom_field_id')->unsigned();
            $table->string('name');
            $table->integer('price')->nullable();
            $table->integer('sort_order');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_product_custom_field_options');
    }
}
