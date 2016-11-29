<?php namespace OFFLINE\SnipcartShop\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOfflineSnipcartshopProducts extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('user_defined_id')->nullable();
            $table->string('name');
            $table->string('slug', 255)->unique();
            $table->text('price');
            $table->string('description_short')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('weight')->nullable()->unsigned();
            $table->integer('width')->nullable()->unsigned();
            $table->integer('length')->nullable()->unsigned();
            $table->integer('height')->nullable()->unsigned();
            $table->integer('quantity_default')->nullable()->unsigned();
            $table->integer('quantity_max')->nullable()->unsigned();
            $table->integer('quantity_min')->nullable()->unsigned();
            $table->integer('stock')->nullable()->default(0);
            $table->string('inventory_management_method')->default('single');
            $table->boolean('allow_out_of_stock_purchases')->default(false);
            $table->boolean('stackable')->default(true);
            $table->boolean('shippable')->default(true);
            $table->boolean('taxable')->default(true);
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_products');
    }
}
