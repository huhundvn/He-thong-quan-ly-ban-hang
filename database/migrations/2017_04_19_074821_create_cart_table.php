<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('cart', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('customer_id') -> nullable();
		    $table->integer('product_id') -> nullable();
		    $table->integer('quantity') -> nullable();
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
	    Schema::dropIfExists('cart');
    }
}
