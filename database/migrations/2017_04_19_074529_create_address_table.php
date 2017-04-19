<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('address', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('customer_id') -> nullable();
		    $table->string('homenumber') -> nullable();
		    $table->string('province') -> nullable();
		    $table->string('district') -> nullable();
		    $table->string('ward') -> nullable();
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
	    Schema::dropIfExists('address');
    }
}
