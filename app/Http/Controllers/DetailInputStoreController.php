<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DetailInputStore;

class DetailInputStoreController extends Controller
{
	// API lấy chi tiết đơn hàng
	public function index()
	{
		return DetailInputStore::all();
	}

	// API tạo chi tiết đơn hàng
	public function store(Request $request)
	{
		$rules = [
			'product_id' => 'required',
			'input_store_id' => 'required',
			'expried_date' => 'required',
			'quantity' => 'required',
			'price' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {

			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	// API xem chi tiết đơn hàng
	public function show($id)
	{
		return DetailInputStore::find($id);
	}

	// API chỉnh sửa thông tin đơn hàng
	public function update(Request $request, $id)
	{

	}

	// API xóa thông tin đơn hàng
	public function destroy($id)
	{
		$deleted = DetailInputStore::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	public function getDetail($inputStoreID)
	{
		return DetailInputStore::where('input_store_id', '=', $inputStoreID)->get();
	}
}
