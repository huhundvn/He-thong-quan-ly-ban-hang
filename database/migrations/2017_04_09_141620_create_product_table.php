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
		    $table->string('name') -> unique();
		    $table->string('code') -> unique();
		    $table->string('description') -> nullable();
		    $table->string('user_guide') -> nullable();
		    $table->integer('manufacturer_id');
		    $table->integer('unit_id');
		    $table->string('weight') -> nullable();
		    $table->string('length') -> nullable();
		    $table->string('volume') -> nullable();
		    $table->integer('viewed') -> nullable();
		    $table->integer('max_inventory') -> nullable();
		    $table->integer('min_inventory') -> nullable();

		    $table->decimal('web_price');
		    $table->string('default_image');
		    $table->integer('total_quantity');
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
