<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DetailInputStore;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DetailInputStoreController extends Controller
{
	// API tạo chi tiết đơn hàng
	public function store(Request $request)
	{
		$rules = [
			'id' => 'required',
			'input_store_id' => 'required',
			'expried_date' => 'required',
			'quantity' => 'required',
			'price_input' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new DetailInputStore();
			$new -> input_store_id = Input::get('input_store_id');
			$new -> product_id = Input::get('id');
			$new -> expried_date = Input::get('expried_date');
			$new -> quantity = Input::get('quantity');
			$new -> price_input = Input::get('price_input');
			$new -> save();
		}
		return response()->json(['success' => trans('message.create_success')]);
	}

	// Xem chi tiết đơn hàng
	public function getDetail($inputStoreID)
	{
		return DetailInputStore::join('product', 'detail_input_store.product_id', '=', 'product.id')
			-> where('detail_input_store.input_store_id', '=', $inputStoreID) -> get();
	}
}
