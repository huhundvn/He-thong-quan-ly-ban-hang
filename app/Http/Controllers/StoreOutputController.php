<?php

namespace App\Http\Controllers;

use App\DetailStoreOutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\StoreOutput;
use App\ProductInStore;
use App\Order;

class StoreOutputController extends Controller
{
	public function index()
	{
		return StoreOutput::with('user')
			-> with('store')
			-> get();
	}

	// API lưu đợt nhập hàng mới
	public function store(Request $request)
	{
		$rules = [
			'store_id' => 'required',
			'order_id' => 'required'
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new StoreOutput();
			$new -> created_by = Auth::user() -> id;
			$new -> store_id = Input::get('store_id');
			$new -> order_id = Input::get('order_id');

			$order = Order::find(Input::get('order_id'));
			$order -> status = 3;
			$order -> save();

			$new -> save();
			return response()->json(['success' => ($new->id)]);
		}
	}

	// API xem thông tin đợt nhập hàng
	public function show($id)
	{
		return StoreOutput::with('user')
			-> with('store')
			-> find($id);
	}

	// API xóa đợt nhập hàng
	public function destroy($id)
	{
		$deleted = StoreOutput::find($id) -> delete();
		$deleted = DetailStoreOutput::where('store_output_id', '=', $id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// Xem lịch sử chuyển kho
	public function listStoreOutput()
	{
		return view('store-output.store-output');
	}

	// Tạo đơn xuất kho mới
	public function createStoreOutput()
	{
		return view('store-output.new-store-output');
	}
}
