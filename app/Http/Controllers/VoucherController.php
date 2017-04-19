<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Voucher;

class VoucherController extends Controller
{
	// API lấy danh sách phiếu thu, chi
	public function index()
	{
		return Voucher::all();
	}

	// API tạo phiếu mới
	public function store(Request $request)
	{
		$rules = [
			'total' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new Voucher();
			$new -> created_by = Input::get('created_by');
			$new -> account_id = Input::get('account_id');
			$new -> name = Input::get('name');
			$new -> address = Input::get('address');
			$new -> total = Input::get('total');
			$new -> description = Input::get('description');
			$new -> type = Input::get('type');
			$new -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	// API lấy thông tin phiếu
	public function show($id)
	{
		return Voucher::find($id);
	}

	//API chỉnh sửa thông tin phiếu
	public function update(Request $request, $id)
	{
		$rules = [
			'name' => 'required|distinct',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = Voucher::find($id);
			$new -> account_id = Input::get('account_id');
			$new -> store_id = Input::get('store_id');
			$new -> receiver_name = Input::get('receiver_name');
			$new -> description = Input::get('description');
			$new -> total = Input::get('total');
			$new -> total_in_words = Input::get('total_in_words');
			$new -> type = Input::get('type');
			$new -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	// API xóa thông tin phiếu
	public function destroy($id)
	{
		$unit = Voucher::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// Xem danh sách đơn vị tính
	public function listVoucher()
	{
		return view('voucher.voucher');
	}
}
