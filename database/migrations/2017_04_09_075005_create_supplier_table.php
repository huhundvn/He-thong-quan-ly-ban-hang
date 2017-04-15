<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('supplier', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name') -> unique();
		    $table->string('email', 100) -> unique();
		    $table->string('phone');
		    $table->string('address');
			$table->string('person_contact');
		    $table->string('bank_account');
		    $table->integer('bank');
		    $table->string('note') -> nullable();
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
	    Schema::dropIfExists('supplier');
    }
}
