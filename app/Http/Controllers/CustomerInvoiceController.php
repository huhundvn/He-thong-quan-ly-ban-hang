<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\CustomerInvoice;

class CustomerInvoiceController extends Controller
{
	//API lấy danh sách hóa đơn
	public function index()
	{
		return CustomerInvoice::all();
	}

	// API tạo hóa đơn mới
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
			$new = new CustomerInvoice();
			$new -> name = Input::get('name');
			$new -> customer_group_id = Input::get('customer_group_id');
			$new -> start_date = Input::get('start_date');
			$new -> end_date = Input::get('end_date');
			$new -> status = 1;
			$new -> save();
		}
		return response()->json(['success' => ($new->id)]);
	}

	// API lấy thông tin hóa đơn
	public function show($id)
	{
		return CustomerInvoice::find($id);
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
		$deleted = CustomerInvoice::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// Xem danh sách hóa đơn
	public function listCustomerInvoice()
	{
		return view('customer-invoice.customer-invoice');
	}

	//Tạo hóa đơn mới
	public function createCustomerInvoice()
	{
		return view('customer-invoice.new-customer-invoice');
	}
}
