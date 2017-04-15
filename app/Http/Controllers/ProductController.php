<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Product;
use App\Category;
use App\Manufacturer;
use App\Unit;

class ProductController extends Controller
{

	/**
	 * API lấy danh sách sản phẩm
	 */
	public function index()
	{
		return Product::all();
	}

	/**
	 * API tạo sản phẩm mới
	 */
	public function store(Request $request)
	{
		// kiểm tra điều kiện
		$rules = [
			'name' => 'required|unique:product,name',
			'code' => 'required|unique:product,code',
			'category_id' => 'required',
			'manufacturer_id' => 'required',
			'unit_id' => 'required',
			'min_inventory' => 'required',
			'max_inventory' => 'required',
			'warranty_period' => 'required',
			'return_period' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$product = new Product();
			$product -> name = Input::get('name');
			$product -> code = Input::get('code');
			$product -> category_id = Input::get('category_id');
			$product -> manufacturer_id = Input::get('manufacturer_id');
			$product -> unit_id = Input::get('unit_id');
			$product -> min_inventory = Input::get('min_inventory');
			$product -> max_inventory = Input::get('max_inventory');
			$product -> warranty_period = Input::get('warranty_period');
			$product -> return_period = Input::get('return_period');
			$product -> weight = Input::get('weight');
			$product -> size = Input::get('size');
			$product -> volume = Input::get('volume');
			$product -> save();
		}
		return response()->json(['success' => trans('message.create_success')]);
	}

	/**
	 * API lấy thông tin sản phẩm
	 */
	public function show($id)
	{
		return Product::find($id);
	}

	/**
	 * API chỉnh sửa thông tin sản phẩm
	 */
	public function update(Request $request, $id)
	{
		// kiểm tra điều kiện
		$rules = [
			'name' => 'required|distinct',
			'code' => 'required|distinct',
			'category_id' => 'required',
			'manufacturer_id' => 'required',
			'unit_id' => 'required',
			'min_inventory' => 'required',
			'max_inventory' => 'required',
			'warranty_period' => 'required',
			'return_period' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$product = Product::find($id);
			$product -> name = Input::get('name');
			$product -> code = Input::get('code');
			$product -> category_id = Input::get('category_id');
			$product -> manufacturer_id = Input::get('manufacturer_id');
			$product -> unit_id = Input::get('unit_id');
			$product -> min_inventory = Input::get('min_inventory');
			$product -> max_inventory = Input::get('max_inventory');
			$product -> warranty_period = Input::get('warranty_period');
			$product -> return_period = Input::get('return_period');
			$product -> weight = Input::get('weight');
			$product -> size = Input::get('size');
			$product -> volume = Input::get('volume');
			$product -> save();
		}
		return response()->json(['success' => trans('message.update_success')]);
	}

	/**
	 * API xóa thông tin một sản phẩm
	 */
	public function destroy($id)
	{
		$deleted = Product::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách sản phẩm
	 */
	public function listProduct()
	{
		return view('product.product');
	}

	/**
	 * Tìm kiếm sản phẩm
	 */
	public function searchProduct($term)
	{
		return Product::where('name', 'LIKE', '%'. $term . '%') -> get();
	}

	/**
	 * Nhập thông tin sản phẩm từ File Excel
	 */
	public function importFromFile(Request $request)
	{
		// kiểm tra điều kiện nhập
		$rules = [
			'ten_san_pham' => 'required',
			'ma_vach' => 'required',
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
					$product = new Product();
					$product -> name = $row -> ten_san_pham;
					$product -> code = $row -> ma_vach;
					$product -> category_id = Category::where('name', '=', $row -> nhom_san_pham)->pluck('id')->first();
					$product -> manufacturer_id = Manufacturer::where('name', '=', $row -> nha_san_xuat)->pluck('id')->first();
					$product -> unit_id = Unit::where('name', '=', $row -> nhom_san_pham) -> pluck('id')->first();
					$product -> min_inventory = $row -> ton_kho_toi_thieu;
					$product -> max_inventory = $row -> ton_kho_toi_da;
					$product -> warranty_period = $row -> thoi_han_bao_hanh;
					$product -> return_period = $row -> thoi_han_doi_tra;
					$product -> weight = $row -> khoi_luong;
					$product -> size = $row -> kich_thuoc;;
					$product -> volume = $row -> the_tich;
					$saved = $product -> save();
					if(!$saved)
						continue;
					else
						$count++;
				}
			}
		}
		return redirect()->route('list-product') -> with('status', 'Đã thêm '.$count.' mục.');
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/san pham.xlsx');
	}
}