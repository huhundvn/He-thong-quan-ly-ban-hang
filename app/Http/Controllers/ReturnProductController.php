<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\ReturnProduct;

class ReturnProductController extends Controller
{
	// API lấy lịch sử nhập hàng
	public function index()
	{
		return Order::with('orderDetails') -> get();
	}

	// API lưu đơn hàng mới
	public function store(Request $request)
	{
		$rules = [
			'customer_id' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new Order();
			$new -> created_by = Auth::user() -> id;
			$new -> customer_id = Input::get('customer_id');

			$new -> payment_method = Input::get('payment_method');
			$new -> bank = Input::get('bank');
			$new -> bank_account = Input::get('bank_account');

			$new -> contact_name = Input::get('contact_name');
			$new -> contact_address = Input::get('contact_address');
			$new -> contact_phone = Input::get('contact_phone');
			$new -> total = Input::get('total');
			$new -> total_paid = Input::get('total_paid');
			$new -> status = 1;
			$new -> save();
			return response()->json(['success' => ($new->id)]);
		}
	}

	// API lấy thông tin bảng giá
	public function show($id)
	{
		return Order::with('orderDetails') -> find($id);
	}

	// API xóa đơn hàng
	public function destroy($id)
	{
		$deleted = Order::find($id) -> delete();
		return response()->json(['success' => 'Xóa đơn hàng thành công']);
	}

	// API xác nhận đơn hàng
	public function confirm($id, $status)
	{
		$selected = Order::find($id);
		$selected -> status = $status;
		$selected -> save();
		return response()->json(['success' => trans('message.update_success')]);
	}

	// Xem lịch sử đơn hàng
	public function listReturnProduct()
	{
		return view('product.return-product');
	}

	// Tạo đơn nhập hàng mới
	public function createReturnProduct()
	{
		return view('product.new-return');
	}
}
