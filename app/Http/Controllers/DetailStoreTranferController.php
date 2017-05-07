<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\DetailStoreTranfer;

class DetailStoreTranferController extends Controller
{
	// API lấy chi tiết chuyển kho
	public function index()
	{
		return DetailStoreTranfer::all();
	}

	// API tạo chi tiết chuyển kho
	public function store(Request $request)
	{
		$rules = [
			'id' => 'required',
			'store_tranfer_id' => 'required',
			'product_id' => 'required',
			'expried_date' => 'required',
			'quantity_tranfer' => 'required',
			'price_input' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new DetailStoreTranfer();
			$new -> store_tranfer_id = Input::get('store_tranfer_id');
			$new -> product_id = Input::get('product_id');
			$new -> expried_date = Input::get('expried_date');
			$new -> quantity_tranfer = Input::get('quantity_tranfer');
			$new -> price_input = Input::get('price_input');
			$new -> supplier_id = Input::get('supplier_id');
			$new -> save();
		}
		return response()->json(['success' => trans('message.create_success')]);
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

	// Xem chi tiết chuyển kho
	public function getDetail($storeTranferID)
	{
		return DetailStoreTranfer::join('product', 'detail_store_tranfer.product_id', '=', 'product.id')
			-> where('detail_store_tranfer.store_tranfer_id', '=', $storeTranferID) -> get();
	}
}
