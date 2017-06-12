<?php namespace OFFLINE\SnipcartShop\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableUpdateOfflineSnipcartshopProducts extends Migration
{
    public function up()
    {
        Schema::table('offline_snipcartshop_products', function ($table) {
            $table->text('properties')->after('stock')->nullable();
            $table->text('links')->after('properties')->nullable();
        });
    }

    public function down()
    {
        Schema::table('offline_snipcartshop_products', function (Blueprint $table) {
            $table->dropColumn(['properties', 'links']);
        });
    }
}
