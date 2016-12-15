<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOfflineSnipcartshopProductAccessory extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_product_accessory', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('accessory_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_product_accessory');
    }
}
