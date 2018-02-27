<?php namespace OFFLINE\SnipcartShop\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class BuilderTableCreateOfflineSnipcartshopOrders extends Migration
{
    public function up()
    {
        Schema::create('offline_snipcartshop_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->uuid('token')->unique();
            $table->string('invoice_number')->nullable();
            $table->string('currency')->nullable();
            $table->timestamp('creation_date')->nullable();
            $table->timestamp('modification_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('email')->nullable();
            $table->boolean('will_be_paid_later')->nullable();
            $table->boolean('shipping_address_same_as_billing')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('credit_card_last4_digits', 4)->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url')->nullable();
            $table->string('shipping_fees')->nullable();
            $table->string('shipping_provider')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway_used')->nullable();
            $table->string('tax_provider')->nullable();
            $table->string('lang');
            $table->float('refunds_amount')->nullable();
            $table->float('adjusted_amount')->nullable();
            $table->float('rebate_amount')->nullable();
            $table->text('taxes')->nullable();
            $table->float('items_total')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('taxable_total')->nullable();
            $table->float('grand_total')->nullable();
            $table->integer('total_weight')->nullable();
            $table->integer('total_rebate_rate')->nullable();
            $table->text('notes')->nullable();
            $table->text('custom_fields')->nullable();
            $table->boolean('shipping_enabled')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->text('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->uuid('user_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_orders');
    }
}
