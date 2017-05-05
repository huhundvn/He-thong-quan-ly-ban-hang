<?php

use Illuminate\Database\Seeder;

class Store extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('store') -> insert([
		    'name' => 'Kho tổng',
		    'type' => 0,
		    'status' => 1,
		    'managed_by' => 1,
	    ]);
    }
}
