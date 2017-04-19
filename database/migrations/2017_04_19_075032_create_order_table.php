<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('order', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('customer_id') -> nullable();
		    $table->integer('customer_group_id') -> nullable();
		    $table->string('name') -> nullable();
		    $table->string('email') -> nullable();
		    $table->string('address') -> nullable();
		    $table->string('phone') -> nullable();
		    $table->integer('total') -> nullable();
		    $table->tinyInteger('status') -> nullable();
		    $table->integer('created_by') -> nullable();
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
	    Schema::dropIfExists('order');
    }
}
