<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOfflineSnipcartshopCategoryProduct extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_category_product', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_category_product');
    }
}
