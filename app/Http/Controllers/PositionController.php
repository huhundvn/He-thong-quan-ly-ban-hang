<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Position;

class PositionController extends Controller
{
	/**
	 * API lấy danh sách chức vụ
	 */
	public function index()
	{
		return Position::all();
	}

	/**
	 * API tạo chức vụ mới
	 */
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:position,name',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new Position();
			$new -> name = Input::get('name');
			$new -> description = Input::get('description');
			$new -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin chức vụ
	 */
	public function show($id)
	{
		return Position::find($id);
	}

	/**
	 * API chỉnh sửa thông tin chức vụ
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
			$unit = Position::find($id);
			$unit -> name = Input::get('name');
			$unit -> description = Input::get('description');
			$unit -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	/**
	 * API xóa thông tin một chức vụ
	 */
	public function destroy($id)
	{
		$unit = Position::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách chức vụ
	 */
	public function listPosition()
	{
		return view('position.position');
	}
}
