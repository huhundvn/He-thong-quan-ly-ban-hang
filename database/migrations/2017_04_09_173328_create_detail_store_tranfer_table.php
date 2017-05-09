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
		    $table->string('expried_date') -> nullable();
		    $table->integer('quantity_tranfer') -> nullable();
		    $table->integer('price_input') -> nullable();
		    $table->integer('supplier_id') -> nullable();
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
