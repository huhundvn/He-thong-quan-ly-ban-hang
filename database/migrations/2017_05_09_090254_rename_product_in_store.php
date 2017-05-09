<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameProductInStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('product_in_store', function (Blueprint $table) {
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
	    Schema::table('product_in_store', function (Blueprint $table) {
		    $table->renameColumn('price_input', 'price');
	    });
    }
}
