<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductAttribute;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductAttributeController extends Controller
{
	// API lấy chi tiết đơn hàng
	public function index()
	{
		return ProductAttribute::all();
	}

	// API tạo thuộc tính sản phẩm
	public function store(Request $request)
	{
		$rules = [
			'id' => 'required',
			'product_id' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new ProductAttribute();
			$new -> product_id = Input::get('product_id');
			$new -> attribute_id = Input::get('id');
			$new -> description = Input::get('description');
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
		$deleted = ProductAttribute::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// Xem chi tiết đơn hàng
	public function getDetail($ID)
	{
		return ProductAttribute::join('attribute', 'attribute.id', '=','product_attribute.attribute_id')
			-> where('product_attribute.product_id', '=', $ID) -> get();
	}
}
