<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('email');
			$table->string('name');
			$table->string('class');
			$table->string('shipping_address');
			$table->string('shipping_city');
			$table->string('shipping_state');
			$table->string('shipping_zip');
			$table->string('business_name');
			$table->dateTime('approved_date');
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
        Schema::dropIfExists('users');
    }
}
