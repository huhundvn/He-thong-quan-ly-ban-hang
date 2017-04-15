<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('store', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name') -> unique();
		    $table->string('email', 100) -> unique();
		    $table->string('address');
		    $table->string('phone');
		    $table->integer('managed_by');
		    $table->tinyInteger('type');
		    $table->tinyInteger('status');
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
	    Schema::dropIfExists('store');
    }
}
