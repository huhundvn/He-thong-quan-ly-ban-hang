<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\ProductImage;

class ProductImageController extends Controller
{

	//	API lấy danh sách ảnh sản phẩm
	public function index()
	{
		return ProductImage::all();
	}

	// API tạo ảnh sản phẩm
	public function store(Request $request)
	{
		$rules = [
			'product_id' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new ProductImage();
			$new -> product_id = Input::get('product_id');
			$new -> image = Input::get('image');
			$new -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin thuộc tính
	 */
	public function show($id)
	{
		return ProductImage::find($id);
	}

	/**
	 * API chỉnh sửa thông tin thuộc tính
	 */
	public function update(Request $request, $id)
	{
		$rules = [
			'name' => 'required|distinct',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$update = Attribute::find($id);
			$update -> name = Input::get('name');
			$update -> description = Input::get('description');
			$update -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	/**
	 * API xóa một thuộc tính
	 */
	public function destroy($id)
	{
		$delete = ProductImage::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}
}
