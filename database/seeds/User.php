<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('user') -> insert([
	    	'id' => 1,
		    'name' => 'Super Admin',
		    'email' => 'admin@gmail.com',
		    'password' => bcrypt('admin123'),
	        'position_id' => 1,
		    'status' => 1,
	    ]);
    }
}
