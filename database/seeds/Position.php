<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class Position extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('position') -> insert([
			'id' => 1,
			'name' => 'Super Admin',
			'description' => 'Quản lý toàn bộ hệ thống',
			'role' => '["order","price-output","return","confirm-order","confirm-price-output","report","customer","product","supplier","manufacturer","store","product-in-store","input-store","price-input","store-tranfer","account","voucher","customer-invoice","supplier-invoice","user","position"]',
		]);
	}
}