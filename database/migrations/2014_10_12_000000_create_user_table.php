<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name') -> nullable();
            $table->string('email') -> nullable();
            $table->string('password') -> nullable();
	        $table->string('address') -> nullable();
	        $table->string('phone') -> nullable();
	        $table->integer('position_id') -> nullable();
	        $table->integer('work_place_id') -> nullable();
	        $table->tinyInteger('status') -> nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('user');
    }
}
