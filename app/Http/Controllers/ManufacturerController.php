<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Manufacturer;

class ManufacturerController extends Controller
{
	/**
	 * API lấy danh sách nhà sản xuất
	 */
	public function index()
	{
		return Manufacturer::all();
	}

	/**
	 * API tạo nhà sản xuất
	 */
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:manufacturer,name',
			'country' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new Manufacturer();
			$new -> name = Input::get('name');
			$new -> country = Input::get('country');
			$new -> description = Input::get('description');
			$new -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin nguồn gốc / xuất sứ
	 */
	public function show($id)
	{
		return Manufacturer::find($id);
	}

	/**
	 * API chỉnh sửa thông tin nguồn gốc / xuất sứ
	 */
	public function update(Request $request, $id)
	{
		$rules = [
			'name' => 'required|distinct',
			'country' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$manufacturer = Manufacturer::find($id);
			$manufacturer -> name = Input::get('name');
			$manufacturer -> country = Input::get('country');
			$manufacturer -> description = Input::get('description');
			$manufacturer -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API xóa thông tin nhà sản xuất
	 */
	public function destroy($id)
	{
		$store = Manufacturer::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách nguồn gốc / xuất sứ
	 */
	public function listManufacturer()
	{
		return view('manufacturer.manufacturer');
	}

	/**
	 * Nhập từ file Excel
	 */
	public function importFromFile(Request $request)
	{
		$rules = [
			'thuong_hieu' => 'required|unique:manufacturer,name',
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
					$new = new Manufacturer();
					$new -> name = $row -> thuong_hieu;
					$new -> country = $row -> quoc_gia;
					$new -> description = $row -> mo_ta;
					$saved = $new -> save();
					if(!$saved)
						continue;
					else
						$count++;
				}
			}
			return redirect()->route('list-manufacturer') -> with('status', 'Đã thêm '.$count.' mục.');;
		}
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/nha san xuat.xlsx');
	}
}