<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('review', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('customer_id') -> nullable();
		    $table->integer('product_id') -> nullable();
		    $table->string('title') -> nullable();
		    $table->string('author') -> nullable();
		    $table->string('text') -> nullable();
		    $table->tinyInteger('rating') -> nullable();
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
	    Schema::dropIfExists('review');
    }
}
