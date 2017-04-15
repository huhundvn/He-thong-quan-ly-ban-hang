<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\Attribute;

class AttributeController extends Controller
{
	/**
	 * API lấy danh sách thuộc tính
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return Attribute::all();
	}

	/**
	 * API tạo thuộc tính mới
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// validate
		$rules = [
			'name' => 'required|unique:attribute,name',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$attribute = new Attribute();
			$attribute -> name = Input::get('name');
			$attribute -> description = Input::get('description');
			$attribute -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin một thuộc tính
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
		return Attribute::find($id);
	}

	/**
	 * API chỉnh sửa thông tin một thuộc tính
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		// validate
		$rules = [
			'name' => 'required|distinct',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$attribute = Attribute::find($id);
			$attribute -> name = Input::get('name');
			$attribute -> description = Input::get('description');
			$attribute -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	/**
	 * API xóa thông tin 1 thuộc tính
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
		$attribute = Attribute::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách thuộc tính
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function listAttribute()
	{
		return view('attribute.attribute');
	}

	/**
	 * Tìm kiếm thuộc tính
	 *
	 * @param $term
	 * @return mixed
	 */
	public function searchAttribute($term)
	{
		return Attribute::where('name', 'LIKE', '%'. $term . '%')
			-> get();
	}
}
