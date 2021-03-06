<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RemoteImageUploader\Factory;

//MODEL CSDL
use App\Product;
use App\Category;
use App\Manufacturer;
use App\Unit;

class ProductController extends Controller
{
	// API LẤY DANH SÁCH SẢN PHẨM
	public function index()
	{
		return Product::with('images')
			-> with('unit')
			-> with('attributes')
			-> with('detailPriceOutputs')
			-> with('detailPriceInputs')
			-> get();
	}

	// API TẠO SẢN PHẨM MỚI
	public function store(Request $request)
	{
		// kiểm tra điều kiện
		$rules = [
			'name' => 'required|unique:product,name',
			'code' => 'unique:product,code',
			'manufacturer_id' => 'required',
			'unit_id' => 'required',
			'web_price' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$product = new Product();
			$product -> name = Input::get('name');
			$product -> code = Input::get('code');
			$product -> description = Input::get('description');
			$product -> user_guide = Input::get('user_guide');
			$product -> category_id = Input::get('category_id');
			$product -> manufacturer_id = Input::get('manufacturer_id');
			$product -> unit_id = Input::get('unit_id');
			$product -> web_price = Input::get('web_price');
			$product -> min_inventory = Input::get('min_inventory');
			$product -> max_inventory = Input::get('max_inventory');
			$product -> warranty_period = Input::get('warranty_period');
			$product -> return_period = Input::get('return_period');
			$product -> weight = Input::get('weight');
			$product -> size = Input::get('size');
			$product -> volume = Input::get('volume');
			$product -> total_quantity = 0;
			$product -> status = 0;
			$product -> default_image = Input::get('default_image');
			$product -> save();
			return response()->json(['success' => ($product->id)]);
		}
	}

	// API XEM THÔNG TIN SẢN PHẨM
	public function show($id)
	{
		return Product::with('images')
			-> with('unit')
			-> with('attributes')
			-> with('detailPriceOutputs')
			-> with('detailPriceInputs')
			-> find($id);
	}

	// API CHỈNH SỬA THÔNG TIN SẢN PHẨM
	public function update(Request $request, $id)
	{
		// kiểm tra điều kiện
		$rules = [
			'name' => 'required|distinct',
			'category_id' => 'required',
			'manufacturer_id' => 'required',
			'unit_id' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$product = Product::find($id);
			$product -> name = Input::get('name');
			$product -> code = Input::get('code');

			$product -> description = Input::get('description');
			$product -> user_guide = Input::get('user_guide');

			$product -> category_id = Input::get('category_id');
			$product -> manufacturer_id = Input::get('manufacturer_id');
			$product -> unit_id = Input::get('unit_id');
			$product -> min_inventory = Input::get('min_inventory');
			$product -> max_inventory = Input::get('max_inventory');
			$product -> web_price = Input::get('web_price');

			$product -> warranty_period = Input::get('warranty_period');
			$product -> return_period = Input::get('return_period');

			$product -> weight = Input::get('weight');
			$product -> size = Input::get('size');
			$product -> volume = Input::get('volume');

			$product -> default_image = Input::get('default_image');
			$product -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	// API XÓA SẢN PHẨM
	public function destroy($id)
	{
		$deleted = Product::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// DANH SÁCH SẢN PHẨM FRONT-END
	public function listProduct()
	{
		return view('product.product');
	}

	// NHẬP TỪ FILE EXCEL
	public function importFromFile(Request $request)
	{
		// kiểm tra điều kiện nhập
		$rules = [
			'ten_san_pham' => 'required|unique:product,name',
			'nha_san_xuat' => 'required',
			'don_vi_tinh' => 'required',
		];

		$count = 0;
		if(Input::hasFile('file')) {
			$rows =  Excel::load(Input::file('file'), function ($reader){
			},'UTF-8') -> get();
			
			foreach ($rows as $row) {
				$validation = Validator::make($row->toArray(), $rules);
				if($validation->fails())
					continue;
				else {
					$product = new Product();
					$product -> name = $row -> ten_san_pham;
					$product -> code = $row -> ma_vach;
					$product -> description = $row -> mo_ta_san_pham;
					$product -> user_guide = $row -> huong_dan_su_dung;
					$category = Category::where('name', '=', $row -> nhom_san_pham) ->get();
					if (count($category) > 0) {
						$product -> category_id = Category::where('name', '=', $row -> nhom_san_pham)->pluck('id')->first();
					} else {
						$newCategory = new Category();
						$newCategory -> name = $row -> nhom_san_pham;
						$newCategory -> save();
						$product -> category_id = Category::where('name', '=', $row -> nhom_san_pham)->pluck('id')->first();
					}
					$manufacturer = Manufacturer::where('name', '=', $row -> nha_cung_cap) ->get();
					if (count($manufacturer) > 0) {
						$product -> manufacturer_id = Manufacturer::where('name', '=', $row -> nha_cung_cap)->pluck('id')->first();
					} else {
						$newManufacturer = new Manufacturer();
						$newManufacturer -> name = $row -> nha_cung_cap;
						$newManufacturer -> save();
						$product -> manufacturer_id = Manufacturer::where('name', '=', $row -> nha_cung_cap)->pluck('id')->first();
					}
					$unit = Unit::where('name', '=', $row -> don_vi_tinh) ->get();
					if (count($unit) > 0) {
						$product -> unit_id = Unit::where('name', '=', $row -> don_vi_tinh)->pluck('id')->first();
					} else {
						$newUnit = new Unit();
						$newUnit -> name = $row -> don_vi_tinh;
						$newUnit -> save();
						$product -> unit_id = Unit::where('name', '=', $row -> don_vi_tinh)->pluck('id')->first();
					}
					$product -> min_inventory = $row -> ton_kho_toi_thieu;
					$product -> max_inventory = $row -> ton_kho_toi_da;
					$product -> warranty_period = $row -> thoi_han_bao_hanh;
					$product -> return_period = $row -> thoi_han_doi_tra;
					$product -> weight = $row -> khoi_luong;
					$product -> size = $row -> kich_thuoc;;
					$product -> volume = $row -> the_tich;
					$product -> total_quantity = 0;
					$product -> status = 0;
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

	// TẢI MẪU NHẬP
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/san pham.xlsx');
	}

	// TẢI ẢNH LÊN FLICKR
	public function uploadImage(Request $request)
	{
		$result = Factory::create(config('uploadphoto.host'), config('uploadphoto.auth'))
			-> upload($request -> file('file') -> path());
		return $result;
	}
}