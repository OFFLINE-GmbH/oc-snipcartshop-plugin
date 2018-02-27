<?php namespace OFFLINE\SnipcartShop\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOfflineSnipcartshopOrderItems extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_order_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->uuid('unique_id');
            $table->integer('product_id');
            $table->integer('order_id');

            $table->string('name');
            $table->float('price');
            $table->float('total_price');
            $table->integer('quantity');
            $table->integer('max_quantity');
            $table->string('url');
            $table->integer('weight')->nullable();
            $table->integer('width')->nullable();
            $table->integer('length')->nullable();
            $table->integer('height')->nullable();
            $table->float('total_weight');
            $table->string('description');
            $table->string('image');
            $table->boolean('stackable');
            $table->boolean('duplicatable');
            $table->boolean('shippable');
            $table->boolean('taxable');
            $table->text('custom_fields');
            $table->text('taxes');
            $table->timestamp('added_on')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_order_items');
    }
}
