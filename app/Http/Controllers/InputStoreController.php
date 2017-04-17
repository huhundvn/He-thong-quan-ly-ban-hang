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
use App\InputStore;

use Carbon\Carbon;

class InputStoreController extends Controller
{
	/**
	 * API lấy danh sách đơn đặt hàng
	 */
	public function index()
	{
		return InputStore::all();
	}

	/**
	 * API tạo đơn đặt hàng mới
	 */
	public function store(Request $request)
	{
		$rules = [
			'store_id' => 'required',
			'account_id' => 'required',
			'supplier_id' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new InputStore();
			$new -> store_id = Input::get('store_id');
			$new -> account_id = Input::get('account_id');
			$new -> input_date = Input::get('input_date');
			$new -> supplier_id = Input::get('supplier_id');
			$new -> status = 1;
			$new -> save();
			return response()->json(['success' => ($new->id)]);
		}
	}

	/**
	 * API lấy thông tin đơn đặt hàng
	 */
	public function show($id)
	{
		return InputStore::find($id);
	}

	/**
	 * API chỉnh sửa thông tin đơn đặt hàng
	 */
	public function update(Request $request, $id)
	{

	}

	/**
	 * API xóa thông tin đơn hàng
	 */
	public function destroy($id)
	{
		$deleted = InputStore::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách đơn đặt hàng
	 */
	public function listInputStore()
	{
		return view('input-store.history-input-store');
	}

	/**
	 * Xem danh sách đơn đặt hàng
	 */
	public function createInputStore()
	{
		return view('input-store.new-input-store');
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
				}
			}
		}
		return redirect()->route('list-product');
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/san pham.xlsx');
	}
}
