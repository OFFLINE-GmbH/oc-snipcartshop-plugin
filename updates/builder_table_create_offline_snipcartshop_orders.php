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
            $table->string('invoice_number');
            $table->string('currency');
            $table->timestamp('creation_date');
            $table->timestamp('modification_date');
            $table->timestamp('completion_date');
            $table->string('status');
            $table->string('payment_status');
            $table->string('email');
            $table->boolean('will_be_paid_later');
            $table->boolean('shipping_address_same_as_billing');
            $table->json('billing_address');
            $table->json('shipping_address');
            $table->string('credit_card_last4_digits', 4);
            $table->string('tracking_number');
            $table->string('tracking_url');
            $table->string('shipping_fees')->nullable();
            $table->string('shipping_provider')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_type')->nullable();
            $table->string('payment_method');
            $table->string('payment_gateway_used');
            $table->string('tax_provider')->nullable();
            $table->string('lang');
            $table->float('refunds_amount')->nullable();
            $table->float('adjusted_amount')->nullable();
            $table->float('rebate_amount')->nullable();
            $table->json('taxes');
            $table->float('items_total');
            $table->float('subtotal');
            $table->float('taxable_total');
            $table->float('grand_total');
            $table->integer('total_weight');
            $table->integer('total_rebate_rate');
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable();
            $table->boolean('shipping_enabled')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->json('metadata');
            $table->string('ip_address');
            $table->uuid('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('offline_snipcartshop_orders');
    }
}
