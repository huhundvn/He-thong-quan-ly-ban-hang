<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Unit;

class UnitController extends Controller
{
	/**
	 * API lấy danh sách đơn vị tính
	 */
	public function index()
	{
		return Unit::all();
	}

	/**
	 * API tạo đơn vị tính mới
	 */
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:unit,name',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$unit = new Unit();
			$unit -> name = Input::get('name');
			$unit -> description = Input::get('description');
			$unit -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin đơn vị tính
	 */
	public function show($id)
	{
		return Unit::find($id);
	}

	/**
	 * API chỉnh sửa thông tin đơn vị tính
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
			$unit = Unit::find($id);
			$unit -> name = Input::get('name');
			$unit -> description = Input::get('description');
			$unit -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API xóa thông tin một đơn vị tính
	 */
	public function destroy($id)
	{
		//
		$unit = Unit::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách đơn vị tính
	 */
	public function listUnit()
	{
		return view('unit.unit');
	}

	/**
	 * Nhập từ file Excel
	 */
	public function importFromFile(Request $request)
	{
		$rules = [
			'ten_don_vi' => 'required|unique:unit,name',
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
					$new = new Unit();
					$new -> name = $row -> ten_don_vi;
					$new -> description = $row -> mo_ta;
					$saved = $new -> save();
					if(!$saved)
						continue;
					else
						$count++;
				}
			}
			return redirect()->route('list-unit') -> with('status', 'Đã thêm '.$count.' mục.');
		}
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/don vi tinh.xlsx');
	}
}
