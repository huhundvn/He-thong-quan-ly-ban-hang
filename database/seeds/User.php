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
	    DB::table('user')->insert([
		    'name' => 'Admin',
		    'email' => 'admin@gmail.com',
		    'password' => bcrypt('admin123'),
	    ]);
    }
}
