<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\PriceInput;

class PriceInputController extends Controller
{
	//API lấy danh sách bảng giá
	public function index()
	{
		return PriceInput::all();
	}

	// API tạo bảng giá mua mới
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:price_input,name',
			'supplier_id' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new PriceInput();
			$new -> name = Input::get('name');
			$new -> supplier_id = Input::get('supplier_id');
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
		return PriceInput::find($id);
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
		$deleted = PriceInput::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// API xác nhận bảng giá
	public function confirm($id, $status)
	{
		$selected = PriceInput::find($id);
		$selected -> status = $status;
		$selected -> save();
		return response()->json(['success' => trans('message.update_success')]);
	}

	// Xem danh sách bảng giá
	public function listPriceInput()
	{
		return view('price-input.price-input');
	}

	//Tạo bảng giá mới
	public function createPriceInput()
	{
		return view('price-input.new-price-input');
	}
}
