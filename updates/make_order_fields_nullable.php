<?php namespace OFFLINE\SnipcartShop\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class MakeOrderFieldsNullableMigration extends Migration
{
    public function up()
    {
        Schema::table('offline_snipcartshop_orders', function(Blueprint $table)
        {
            $table->string('token', 36)->nullable(true)->change();
            $table->string('invoice_number', 255)->nullable(true)->change();
            $table->string('currency', 255)->nullable(true)->change();
            $table->string('status', 255)->nullable(true)->change();
            $table->string('payment_status', 255)->nullable(true)->change();
            $table->string('email', 255)->nullable(true)->change();
            $table->boolean('will_be_paid_later')->nullable(true)->change();
            $table->boolean('shipping_address_same_as_billing')->nullable(true)->change();
            $table->text('billing_address')->nullable(true)->change();
            $table->text('shipping_address')->nullable(true)->change();
            $table->string('credit_card_last4_digits', 4)->nullable(true)->change();
            $table->string('tracking_number', 255)->nullable(true)->change();
            $table->string('tracking_url', 255)->nullable(true)->change();
            $table->string('payment_method', 255)->nullable(true)->change();
            $table->string('payment_gateway_used', 255)->nullable(true)->change();
            $table->string('lang', 255)->nullable(true)->change();
            $table->text('taxes')->nullable(true)->change();
            $table->decimal('items_total', 8, 2)->nullable(true)->change();
            $table->decimal('subtotal', 8, 2)->nullable(true)->change();
            $table->decimal('taxable_total', 8, 2)->nullable(true)->change();
            $table->decimal('grand_total', 8, 2)->nullable(true)->change();
            $table->integer('total_weight')->nullable(true)->change();
            $table->integer('total_rebate_rate')->nullable(true)->change();
            $table->text('metadata')->nullable(true)->change();
            $table->string('ip_address', 255)->nullable(true)->change();
            $table->string('user_id', 36)->nullable(true)->change();
        });
    }

    public function down()
    {
        Schema::table('offline_snipcartshop_orders', function($table)
        {
            $table->string('token', 36)->nullable(false)->change();
            $table->string('invoice_number', 255)->nullable(false)->change();
            $table->string('currency', 255)->nullable(false)->change();
            $table->string('status', 255)->nullable(false)->change();
            $table->string('payment_status', 255)->nullable(false)->change();
            $table->string('email', 255)->nullable(false)->change();
            $table->boolean('will_be_paid_later')->nullable(false)->change();
            $table->boolean('shipping_address_same_as_billing')->nullable(false)->change();
            $table->text('billing_address')->nullable(false)->change();
            $table->text('shipping_address')->nullable(false)->change();
            $table->string('credit_card_last4_digits', 4)->nullable(false)->change();
            $table->string('tracking_number', 255)->nullable(false)->change();
            $table->string('tracking_url', 255)->nullable(false)->change();
            $table->string('payment_method', 255)->nullable(false)->change();
            $table->string('payment_gateway_used', 255)->nullable(false)->change();
            $table->string('lang', 255)->nullable(false)->change();
            $table->text('taxes')->nullable(false)->change();
            $table->decimal('items_total', 8, 2)->nullable(false)->change();
            $table->decimal('subtotal', 8, 2)->nullable(false)->change();
            $table->decimal('taxable_total', 8, 2)->nullable(false)->change();
            $table->decimal('grand_total', 8, 2)->nullable(false)->change();
            $table->integer('total_weight')->nullable(false)->change();
            $table->integer('total_rebate_rate')->nullable(false)->change();
            $table->text('metadata')->nullable(false)->change();
            $table->string('ip_address', 255)->nullable(false)->change();
            $table->string('user_id', 36)->nullable(false)->change();
        });
    }
}
