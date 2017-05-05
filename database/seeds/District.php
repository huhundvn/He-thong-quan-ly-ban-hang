<?php

use Illuminate\Database\Seeder;

class District extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::unprepared(File::get('resources/assets/district.sql'));
    }
}
