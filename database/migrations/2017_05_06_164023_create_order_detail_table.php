<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('order_detail', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('order_id') -> nullable();
		    $table->integer('product_id') -> nullable();
		    $table->integer('price') -> nullable();
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
	    Schema::dropIfExists('order_detail');
    }
}
