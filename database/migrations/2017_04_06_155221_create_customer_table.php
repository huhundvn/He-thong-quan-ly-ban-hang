<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('customer', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
		    $table->string('email', 100) -> unique();
		    $table->string('address');
		    $table->string('phone');
		    $table->integer('bank_id');
		    $table->string('bank_account');
		    $table->integer('customer_group_id');
		    $table->string('note') -> nullable();
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
	    Schema::dropIfExists('customer');
    }
}
