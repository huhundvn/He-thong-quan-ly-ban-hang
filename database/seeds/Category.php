<?php

use Illuminate\Database\Seeder;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('category') -> insert([
		    'name' => 'Nhóm mặc định',
	    ]);
    }
}
