<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Attribute;

class AttributeController extends Controller
{
	/**
	 * API lấy danh sách thuộc tính
	 */
	public function index()
	{
		return Attribute::all();
	}

	/**
	 * API tạo thuộc tính mới
	 */
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:attribute,name',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$unit = new Attribute();
			$unit -> name = Input::get('name');
			$unit -> description = Input::get('description');
			$unit -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin thuộc tính
	 */
	public function show($id)
	{
		return Attribute::find($id);
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
		$delete = Attribute::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách thuộc tính
	 */
	public function listAttribute()
	{
		return view('attribute.attribute');
	}

	/**
	 * Nhập từ file Excel
	 */
	public function importFromFile(Request $request)
	{
		$rules = [
			'ten_thuoc_tinh' => 'required|unique:attribute,name',
		];

		if(Input::hasFile('file')) {
			$rows =  Excel::load(Input::file('file'), function ($reader){
			},'UTF-8') -> get();
			$count = 0;
			foreach ($rows as $row) {
				$validation = Validator::make($row->toArray(), $rules);
				if($validation->fails())
					continue;
				else {
					$new = new Attribute();
					$new -> name = $row -> ten_thuoc_tinh;
					$new -> description = $row -> mo_ta;
					$saved = $new -> save();
					if(!$saved)
						continue;
					else
						$count++;
				}
			}
			return redirect()->route('list-attribute') -> with('status', 'Đã thêm '.$count.' mục.');
		}
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/thuoc tinh.xlsx');
	}
}
