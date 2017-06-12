<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateOfflineSnipcartshopCategories extends Migration
{
    public function up()
    {
        Schema::table('offline_snipcartshop_categories', function($table)
        {
            $table->string('code')->after('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('offline_snipcartshop_categories', function($table)
        {
            $table->dropColumn('code');
        });
    }
}
