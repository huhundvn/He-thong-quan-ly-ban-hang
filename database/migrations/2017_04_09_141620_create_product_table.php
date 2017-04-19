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
		    $table->text('description') -> nullable();
		    $table->text('user_guide') -> nullable();
		    $table->integer('manufacturer_id') -> nullable();
		    $table->integer('unit_id') -> nullable();
		    $table->integer('category_id') -> nullable();

		    $table->integer('warranty_period') -> nullable();
		    $table->integer('return_period') -> nullable();

		    $table->string('weight') -> nullable();
		    $table->string('size') -> nullable();
		    $table->string('volume') -> nullable();
		    $table->integer('viewed') -> nullable();
		    $table->integer('rate') -> nullable();
		    $table->integer('max_inventory') -> nullable();
		    $table->integer('min_inventory') -> nullable();

		    $table->decimal('web_price') -> nullable();
		    $table->string('default_image') -> nullable();
		    $table->integer('total_quantity') -> nullable();

		    $table->tinyInteger('status') -> nullable();

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
