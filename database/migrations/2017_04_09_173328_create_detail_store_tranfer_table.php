<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailStoreTranferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('detail_store_tranfer', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('store_tranfer_id');
		    $table->integer('product_id');
		    $table->dateTime('expried_date');
		    $table->integer('quantity');
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
	    Schema::dropIfExists('detail_store_tranfer');
    }
}
