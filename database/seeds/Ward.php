<?php

use Illuminate\Database\Seeder;

class Ward extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::unprepared(File::get('resources/assets/ward.sql'));
    }
}
