<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTranferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('store_tranfer', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('from_store_id');
		    $table->integer('to_store_id');
		    $table->string('reason');
		    $table->tinyInteger('status');
		    $table->integer('approved_by');
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
	    Schema::dropIfExists('store_tranfer');
    }
}
