<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameInputStorePrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('input_store', function (Blueprint $table) {
		    $table->renameColumn('price', 'price_input');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('input_store', function (Blueprint $table) {
		    $table->renameColumn('price_input', 'price');
	    });
    }
}
