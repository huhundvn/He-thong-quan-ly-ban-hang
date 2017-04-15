<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('product', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name') -> nullable();
		    $table->string('code') -> nullable();
		    $table->string('description') -> nullable();
		    $table->string('user_guide') -> nullable();
		    $table->integer('manufacturer_id') -> nullable();
		    $table->integer('unit_id') -> nullable();
		    $table->string('weight') -> nullable();
		    $table->string('length') -> nullable();
		    $table->string('volume') -> nullable();
		    $table->integer('viewed') -> nullable();
		    $table->integer('max_inventory') -> nullable();
		    $table->integer('min_inventory') -> nullable();

		    $table->decimal('web_price') -> nullable();
		    $table->string('default_image') -> nullable();
		    $table->integer('total_quantity') -> nullable();
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
	    Schema::dropIfExists('product');
    }
}
