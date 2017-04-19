<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('voucher', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('created_by') -> nullable();
		    $table->integer('account_id') -> nullable();
		    $table->integer('store_id') -> nullable();
		    $table->string('receiver_name') -> nullable();
		    $table->integer('total') -> nullable();
		    $table->string('total_in_words') -> nullable();
		    $table->string('description') -> nullable();
		    $table->tinyInteger('type') -> nullable();
		    $table->tinyInteger('status') -> nullable();
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
	    Schema::dropIfExists('voucher');
    }
}
