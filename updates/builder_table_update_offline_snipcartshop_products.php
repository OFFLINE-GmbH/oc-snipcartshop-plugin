<?php namespace OFFLINE\SnipcartShop\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOfflineSnipcartshopProducts extends Migration
{
    public function up()
    {
        Schema::table('offline_snipcartshop_products', function($table)
        {
            $table->text('properties')->after('stock')->nullable();
            $table->text('links')->after('properties')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('offline_snipcartshop_products', function($table)
        {
            $table->dropColumn('properties');
            $table->dropColumn('links');
        });
    }
}
