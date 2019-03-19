<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateB2bMemberRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b2b_member_requests', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('email',128)->unique();
			$table->string('name');
			$table->string('password_hash');
			$table->string('shipping_address');
			$table->string('shipping_city');
			$table->string('shipping_state');
			$table->string('shipping_zip');
			$table->string('business_name');
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
        Schema::dropIfExists('b2b_member_requests');
    }
}
