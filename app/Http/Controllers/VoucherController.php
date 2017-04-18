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
	// API lấy danh sách đơn vị tính
	public function index()
	{
		return Voucher::all();
	}

	// API tạo phiếu mới
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:unit,name',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$unit = new Unit();
			$unit -> name = Input::get('name');
			$unit -> description = Input::get('description');
			$unit -> save();
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
			$unit = Unit::find($id);
			$unit -> name = Input::get('name');
			$unit -> description = Input::get('description');
			$unit -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	// API xóa thông tin phiếu
	public function destroy($id)
	{
		$unit = Unit::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// Xem danh sách đơn vị tính
	public function listVoucher()
	{
		return view('voucher.voucher');
	}
}
