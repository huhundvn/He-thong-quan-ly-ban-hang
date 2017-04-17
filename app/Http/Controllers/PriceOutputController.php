<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\PriceOutput;

class PriceOutputController extends Controller
{
	//API lấy danh sách bảng giá
	public function index()
	{
		return PriceOutput::all();
	}

	// API tạo nhà cung cấp mới
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:price_output,name',
			'customer_group_id' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new PriceOutput();
			$new -> name = Input::get('name');
			$new -> customer_group_id = Input::get('customer_group_id');
			$new -> start_date = Input::get('start_date');
			$new -> end_date = Input::get('end_date');
			$new -> status = 1;
			$new -> save();
		}
		return response()->json(['success' => ($new->id)]);
	}

	// API lấy thông tin bảng giá
	public function show($id)
	{
		return PriceOutput::find($id);
	}

	// API chỉnh sửa bảng giá
	public function update(Request $request, $id)
	{
		$rules = [
			'name' => 'required|distinct',
			'customer_group_id' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new PriceOutput();
			$new -> name = Input::get('name');
			$new -> customer_group_id = Input::get('customer_group_id');
			$new -> start_date = Input::get('start_date');
			$new -> end_date = Input::get('end_date');
			$new -> status = Input::get('status');
			$new -> save();
		}
		return response()->json(['success' => trans('message.update_success')]);
	}

	// API xóa bảng giá
	public function destroy($id)
	{
		$deleted = PriceOutput::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// Xem danh sách bảng giá
	public function listPriceOutput()
	{
		return view('price-output.price-output');
	}

	//Tạo bảng giá mới
	public function createPriceOutput()
	{
		return view('price-output.new-price-output');
	}
}
