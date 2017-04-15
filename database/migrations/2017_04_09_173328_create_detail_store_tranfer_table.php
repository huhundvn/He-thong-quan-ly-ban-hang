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
		    $table->integer('store_tranfer_id') -> nullable();
		    $table->integer('product_id') -> nullable();
		    $table->dateTime('expried_date') -> nullable();
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
	    Schema::dropIfExists('detail_store_tranfer');
    }
}
