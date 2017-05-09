<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailStoreOutputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('detail_store_output', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('store_output_id') -> nullable();
		    $table->integer('product_id') -> nullable();
		    $table->integer('store_id') -> nullable();

		    $table->integer('price_input') -> nullable();
		    $table->integer('price_output') -> nullable();

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
	    Schema::dropIfExists('detail_store_output');
    }
}
