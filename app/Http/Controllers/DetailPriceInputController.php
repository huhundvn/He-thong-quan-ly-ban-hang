<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

use App\DetailPriceInput;

class DetailPriceInputController extends Controller
{
	// API lấy chi tiết giá bán
	public function index()
	{
		return PriceDetailInput::with('product') -> get();
	}

	// API tạo chi tiết đơn hàng
	public function store(Request $request)
	{
		$rules = [
			'price_input_id' => 'required',
			'id' => 'required',
			'price_input' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new DetailPriceInput();
			$new -> price_input_id = Input::get('price_input_id');
			$new -> product_id = Input::get('id');
			$new -> price_input = Input::get('price_input');
			$new -> save();
		}
		return response()->json(['success' => trans('message.create_success')]);
	}

	// API xem chi tiết đơn hàng
	public function show($id)
	{
		return PriceDetailInput::with('product') -> find($id);
	}

	// API chỉnh sửa thông tin đơn hàng
	public function update(Request $request, $id)
	{

	}

	// API xóa thông tin đơn hàng
	public function destroy($id)
	{
		$deleted = DetailPriceInput::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// Xem chi tiết
	public function getDetail($priceInputID)
	{
		return DetailPriceInput::join('product', 'detail_price_input.product_id', '=', 'product.id')
			-> where('detail_price_input.price_input_id', '=', $priceInputID) -> get();
	}
}
