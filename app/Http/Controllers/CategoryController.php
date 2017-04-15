<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//Model CSDL
use App\Category;

class CategoryController extends Controller
{
	/**
	 * API lấy danh sách nhóm sản phẩm
	 */
	public function index()
	{
		return Category::all();
	}

	/**
	 * API tạo nhóm sản phẩm mới
	 */
	public function store(Request $request)
	{
		// validate
		$rules = [
			'name' => 'required|unique:category,name',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$category = new Category();
			if(Input::get('parent_id') != '') {
				$category -> name = Category::find(Input::get('parent_id')) -> name .' > '. Input::get('name');
				$category -> parent_id = Input::get('parent_id');
			} else {
				$category -> name = Input::get('name');
			}
			$category -> description = Input::get('description');
			$category -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin một nhóm sản phẩm
	 */
	public function show($id)
	{
		return Category::find($id);
	}

	/**
	 * API chỉnh sửa thông tin một nhóm sản phẩm
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
			$category = Category::find($id);
			if(Input::get('parent_id') != '') {
				$category -> name = Category::find(Input::get('parent_id')) -> name .' > '. Input::get('name');
				$category -> parent_id = Input::get('parent_id');
			} else {
				$category -> name = Input::get('name');
			}
			$category -> description = Input::get('description');
			$category -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	/**
	 * API xóa thông tin 1 thuộc tính
	 */
	public function destroy($id)
	{
		//
		$category = Category::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách thuộc tính
	 */
	public function listCategory()
	{
		return view('product.category');
	}

	/**
	 * Tìm kiếm thuộc tính
	 */
	public function searchCategory($term)
	{
		return Category::where('name', 'LIKE', '%'. $term . '%') -> get();
	}

	/**
	 * Nhập thông tin từ File Excel
	 */
	public function importFromFile(Request $request)
	{
		// kiểm tra điều kiện nhập
		$rules = [
			'ten_nhom' => 'required|unique:category,name',
		];

		if(Input::hasFile('file')) {
			$rows =  Excel::load(Input::file('file'), function ($reader){
			},'UTF-8') -> get();
			foreach ($rows as $row) {
				$validation = Validator::make($row -> toArray(), $rules);
				if($validation->fails()) {
					continue;
				} else {
					$new = new Category();
					$new -> name = $row -> ten_nhom;
					$new -> parent_id = Category::where('name', '=', $row -> nhom_cha) -> pluck('id') -> first();
					$new -> description = $row -> mo_ta;
					$saved = $new -> save();
					if(!$saved)
						continue;
				}
			}
		}
		return redirect()->route('list-category') -> with('status', 'Thành công');
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/nhom san pham.xlsx');
	}
}
