<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOfflineSnipcartshopOrders extends Migration
{
    public function up()
    {
        Schema::table('offline_snipcartshop_orders', function($table)
        {
            $table->text('discounts')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('offline_snipcartshop_orders', function($table)
        {
            $table->dropColumn('discounts');
        });
    }
}
