<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPriceInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('detail_price_input', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('price_input_id') -> nullable();
		    $table->integer('product_id') -> nullable();
		    $table->integer('price_input') -> nullable();
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
	    Schema::dropIfExists('detail_price_input');
    }
}
