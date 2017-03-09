<?php namespace OFFLINE\SnipcartShop\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class SetSortOrderDefaults extends Migration
{
    public function up()
    {
        Schema::table('offline_snipcartshop_categories', function(Blueprint $table) {
            $table->integer('sort_order')->default(0)->change();
        });

        Schema::table('offline_snipcartshop_product_custom_field_options', function(Blueprint $table) {
            $table->integer('sort_order')->default(0)->change();
        });
    }
    
    public function down()
    {

    }
}
