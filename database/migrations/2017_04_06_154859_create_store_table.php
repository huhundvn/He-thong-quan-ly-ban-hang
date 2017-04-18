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
		    $table->string('name') -> nullable();
		    $table->string('email', 100) -> nullable();
		    $table->string('address') -> nullable();
		    $table->string('phone') -> nullable();
		    $table->integer('managed_by') -> nullable();
		    $table->integer('store_id') -> nullable();
		    $table->tinyInteger('type') -> nullable();
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
	    Schema::dropIfExists('store');
    }
}
