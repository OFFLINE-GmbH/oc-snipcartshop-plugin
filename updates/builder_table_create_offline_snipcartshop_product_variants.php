<?php namespace OFFLINE\SnipcartShop\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOfflineSnipcartshopProductVariants extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_product_variants', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('stock')->nullable();
            $table->boolean('allow_out_of_stock_purchases')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_product_variants');
    }
}
