<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('input_store', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name') -> nullable();
		    $table->string('input_date') -> nullable();
		    $table->integer('created_by') -> nullable();
		    $table->integer('store_id') -> nullable();
		    $table->integer('account_id') -> nullable();
		    $table->integer('supplier_id') -> nullable();
		    $table->integer('total') -> nullable();
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
	    Schema::dropIfExists('input_store');
    }
}
