<?php

use Illuminate\Database\Seeder;

class CustomerGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('customer_group') -> insert([
		    'name' => 'Khách lẻ',
		    'description' => 'Khách mua với số lượng ít',
	    ]);
    }
}
