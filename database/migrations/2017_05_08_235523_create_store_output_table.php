<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreOutputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('store_output', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('created_by') -> nullable();
		    $table->integer('store_id') -> nullable();
		    $table->integer('order_id') -> nullable();

		    $table->timestamps();
		    $table->softDeletes();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('store_output');
    }
}
