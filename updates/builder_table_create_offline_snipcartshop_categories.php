<?php namespace OFFLINE\SnipcartShop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateOfflineSnipcartshopCategories extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned();
            $table->string('name', 255);
            $table->string('meta_title');
            $table->text('meta_description');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_categories');
    }
}
