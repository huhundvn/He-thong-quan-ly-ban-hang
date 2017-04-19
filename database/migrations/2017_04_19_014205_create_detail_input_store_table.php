<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailInputStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('detail_input_store', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('input_store_id') -> nullable();
		    $table->integer('product_id') -> nullable();
		    $table->integer('price') -> nullable();
		    $table->integer('quantity') -> nullable();
		    $table->string('expried_date') -> nullable();
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
	    Schema::dropIfExists('detail_input_store');
    }
}
