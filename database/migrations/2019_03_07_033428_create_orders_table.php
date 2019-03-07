<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('customer_name');
			$table->string('order_number');
			$table->string('tracking_number');
			$table->string('stripe_transaction_id');
			$table->dateTime('order_date');
			$table->string('line_item_details');
			$table->integer('shipping_cost');
			$table->string('shipping_address');
			$table->string('shipping_city');
			$table->string('shipping_state');
			$table->string('shipping_zip');
			$table->integer('order_total');
			$table->boolean('paid');
			$table->boolean('shipped');
			$table->enum('class', ['b2b', 'direct']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
