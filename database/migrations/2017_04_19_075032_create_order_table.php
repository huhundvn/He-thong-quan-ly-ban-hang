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

		    $table->integer('price_output_id') -> nullable();

		    $table->string('contact_name') -> nullable();
		    $table->string('contact_email') -> nullable();
		    $table->string('contact_address') -> nullable();
		    $table->string('contact_phone') -> nullable();
		    $table->integer('total') -> nullable();
		    $table->integer('total_paid') -> nullable();

		    $table->tinyInteger('status') -> nullable();
		    $table->integer('created_by') -> nullable();

		    $table->string('payment_method') -> nullable();
		    $table->string('bank') -> nullable();
		    $table->string('bank_account') -> nullable();
		    $table->integer('account_id') -> nullable();

		    $table->integer('tax') -> nullable() -> change();
		    $table->integer('discount') -> nullable() -> change();

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
