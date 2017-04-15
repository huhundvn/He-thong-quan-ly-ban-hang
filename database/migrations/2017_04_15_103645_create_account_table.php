<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('account', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name') -> nullable();
		    $table->string('bank_account') -> nullable();
		    $table->string('bank') -> nullable();
		    $table->integer('total') -> nullable();
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
	    Schema::dropIfExists('account');
    }
}
