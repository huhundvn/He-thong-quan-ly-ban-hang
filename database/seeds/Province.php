<?php

use Illuminate\Database\Seeder;

class Province extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::unprepared(File::get('resources/assets/province.sql'));
    }
}
