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
		    $table->string('name') -> nullable();
		    $table->string('email', 100) -> nullable();
		    $table->string('phone') -> nullable();
		    $table->string('address') -> nullable();
			$table->string('person_contact') -> nullable();
		    $table->string('bank_account') -> nullable();
		    $table->string('bank') -> nullable();
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
