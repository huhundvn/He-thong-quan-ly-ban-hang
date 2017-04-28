<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\Product;
use App\InputStore;
use App\ProductInStore;

class InputStoreController extends Controller
{
	// API lấy lịch sử nhập hàng
	public function index()
	{
		return InputStore::all();
	}

	// API lưu đợt nhập hàng mới
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
			$new -> created_by = Auth::user() -> id;
			$new -> store_id = Input::get('store_id');
			$new -> account_id = Input::get('account_id');
			$new -> input_date = Input::get('input_date');
			$new -> supplier_id = Input::get('supplier_id');
			$new -> total = Input::get('total');
			$new -> status = 1;
			$new -> save();
			return response()->json(['success' => ($new->id)]);
		}
	}

	// API xem thông tin đợt nhập hàng
	public function show($id)
	{
		return InputStore::find($id);
	}

	// API chỉnh sửa thông tin đợt nhập hàng
	public function update(Request $request, $id)
	{

	}

	// API xóa đợt nhập hàng
	public function destroy($id)
	{
		$deleted = InputStore::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// API xác nhận đơn hàng
	public function confirm($id, $status)
	{
		$selected = InputStore::find($id);
		// Nhập hàng vao kho, cập nhật số lượng
		if($status==3 && ($selected -> status) !=3) { //Nếu nhập hàng cập nhật số lượng trên toàn hệ thống và các kho hàng
			$rows = InputStore::join('detail_input_store', 'detail_input_store.input_store_id', '=', 'input_store.id')
				-> where('input_store.id', '=', $id)
				-> get(); //Lây chi tiết danh sách các mặt hàng cần nhập
			foreach ($rows as $row) {
				// Cập nhật tổng số lượng sản phẩm cả hệ thống
				$update = Product::find($row->product_id);
				$update -> total_quantity += $row -> quantity;
				$update -> status = 1;
				$update -> save();
				// Cập nhật hàng trong kho tương ứng
				$update2 = new ProductInStore();
				$update2 -> product_id = $row -> product_id;
				$update2 -> store_id = $row -> store_id;
				$update2 -> supplier_id = $row -> supplier_id;
				$update2 -> quantity = $row -> quantity;
				$update2 -> price = $row -> price;
				$update2 -> expried_date = $row -> expried_date;
				$update2 -> save();
			}
		}
		$selected -> status = $status;
		$selected -> save();
		return response()->json(['success' => trans('message.update_success')]);
	}

	// Xem lịch sử nhập hàng
	public function listInputStore()
	{
		return view('input-store.input-store');
	}

	// Tạo đơn nhập hàng mới
	public function createInputStore()
	{
		return view('input-store.new-input-store');
	}
}
