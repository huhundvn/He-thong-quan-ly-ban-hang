<?php

namespace App\Http\Controllers;

use App\DetailPriceOutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DetailPriceOutputController extends Controller
{
	// API lấy chi tiết giá bán
	public function index()
	{
		return DetailPriceOutput::with('product')-> get();
	}

	// API tạo chi tiết đơn hàng
	public function store(Request $request)
	{
		$rules = [
			'price_output_id' => 'required',
			'id' => 'required',
			'price_output' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new DetailPriceOutput();
			$new -> price_output_id = Input::get('price_output_id');
			$new -> product_id = Input::get('id');
			$new -> price_output = Input::get('price_output');
			$new -> save();
		}
		return response()->json(['success' => trans('message.create_success')]);
	}

	// API xem chi tiết đơn hàng
	public function show($id)
	{
		return DetailPriceOutput::with('product')->find($id);
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

	// Xem chi tiết đơn hàng
	public function getDetail($priceOutputID)
	{
		return DetailPriceOutput::join('product', 'detail_price_output.product_id', '=', 'product.id')
			-> where('detail_price_output.price_output_id', '=', $priceOutputID) -> get();
	}
}
