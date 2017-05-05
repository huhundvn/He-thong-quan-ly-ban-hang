<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(User::class);
	    $this->call(Position::class);
	    $this->call(CustomerGroup::class);
	    $this->call(Category::class);
	    $this->call(Store::class);
	    $this->call(Account::class);
	    $this->call(Province::class);
	    $this->call(District::class);
//	    $this->call(Ward::class);
    }
}
