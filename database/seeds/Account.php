<?php

use Illuminate\Database\Seeder;

class Account extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('account') -> insert([
		    'name' => 'Tiền mặt',
	    ]);
    }
}
