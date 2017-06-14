<?php namespace OFFLINE\SnipcartShop\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class MakeOrderItemsFieldsNullableMigration extends Migration
{
    public function up()
    {
        Schema::table('offline_snipcartshop_order_items', function($table)
        {
            $table->string('unique_id', 36)->nullable()->change();
            $table->integer('product_id')->nullable()->change();
            $table->integer('order_id')->nullable()->change();
            $table->string('name', 255)->nullable()->change();
            $table->decimal('price', 8, 2)->nullable()->change();
            $table->decimal('total_price', 8, 2)->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->integer('max_quantity')->nullable()->change();
            $table->string('url', 255)->nullable()->change();
            $table->decimal('total_weight', 8, 2)->nullable()->change();
            $table->string('description', 255)->nullable()->change();
            $table->string('image', 255)->nullable()->change();
            $table->boolean('stackable')->nullable()->change();
            $table->boolean('duplicatable')->nullable()->change();
            $table->boolean('shippable')->nullable()->change();
            $table->boolean('taxable')->nullable()->change();
            $table->text('custom_fields')->nullable()->change();
            $table->text('taxes')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('offline_snipcartshop_order_items', function($table)
        {
            $table->string('unique_id', 36)->nullable(false)->change();
            $table->integer('product_id')->nullable(false)->change();
            $table->integer('order_id')->nullable(false)->change();
            $table->string('name', 255)->nullable(false)->change();
            $table->decimal('price', 8, 2)->nullable(false)->change();
            $table->decimal('total_price', 8, 2)->nullable(false)->change();
            $table->integer('quantity')->nullable(false)->change();
            $table->integer('max_quantity')->nullable(false)->change();
            $table->string('url', 255)->nullable(false)->change();
            $table->decimal('total_weight', 8, 2)->nullable(false)->change();
            $table->string('description', 255)->nullable(false)->change();
            $table->string('image', 255)->nullable(false)->change();
            $table->boolean('stackable')->nullable(false)->change();
            $table->boolean('duplicatable')->nullable(false)->change();
            $table->boolean('shippable')->nullable(false)->change();
            $table->boolean('taxable')->nullable(false)->change();
            $table->text('custom_fields')->nullable(false)->change();
            $table->text('taxes')->nullable(false)->change();
        });
    }
}
