<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

use App\DetailStoreOutput;
use App\Product;
use App\ProductInStore;

class DetailStoreOutputController extends Controller
{
	// API tạo chi tiết xuất kho
	public function store(Request $request)
	{
		$rules = [
			'store_output_id' => 'required',
			'product_id' => 'required',
			'expried_date' => 'required',
			'quantity' => 'required',
			'price_input' => 'required',
			'price' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new DetailStoreOutput();
			$new -> store_output_id = Input::get('store_output_id');
			$new -> store_id = Input::get('store_id');
			$new -> product_id = Input::get('product_id');
			$new -> expried_date = Input::get('expried_date');
			$new -> quantity = Input::get('quantity');
			$new -> price_input = Input::get('price_input');
			$new -> price_output = Input::get('price');

			$productInStore = ProductInStore::where('store_id', '=', Input::get('store_id'))
								-> where('product_id', '=', Input::get('product_id'))
								-> where('price_input', '=', Input::get('price_input'))
								-> where('expried_date', '=', Input::get('expried_date'))
								-> first();
			$productInStore -> quantity -= Input::get('quantity');
			$productInStore -> save();

			$product = Product::find(Input::get('product_id'));
			$product -> total_quantity -= Input::get('quantity');
			$product -> save();

			$new -> save();
		}
		return response()->json(['success' => trans('message.create_success')]);
	}

	// Xem chi tiết xuất kho
	public function getDetail($storeOutputID)
	{
		return DetailStoreOutput::join('product', 'detail_store_output.product_id', '=', 'product.id')
			-> where('detail_store_output.store_output_id', '=', $storeOutputID) -> get();
	}
}
