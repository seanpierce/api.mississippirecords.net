<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertiesToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
			$table->string('description');
			$table->float('basic_cost', 8, 2);
			$table->float('b2b_cost', 8, 2);
			$table->string('images');
			$table->string('audio');
			$table->integer('quantity_available');
			$table->string('catalog');
			$table->string('category');
			$table->boolean('presale');
			$table->boolean('b2b_enabled');
			$table->boolean('direct_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}
