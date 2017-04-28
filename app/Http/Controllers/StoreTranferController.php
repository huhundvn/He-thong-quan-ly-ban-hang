<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\StoreTranfer;
use App\ProductInStore;

class StoreTranferController extends Controller
{
	// API lấy lịch sử nhập hàng
	public function index()
	{
		return StoreTranfer::with('detailStoreTranfers') -> get();
	}

	// API lưu chuyển kho mới
	public function store(Request $request)
	{
		$rules = [
			'store_id' => 'required',
			'to_store_id' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new StoreTranfer();
			$new -> created_by = Auth::user() -> id;
			$new -> from_store_id = Input::get('store_id');
			$new -> to_store_id = Input::get('to_store_id');
			$new -> reason = Input::get('reason');
			$new -> status = 1;
			$new -> save();
			return response()->json(['success' => ($new->id)]);
		}
	}

	// API xem thông tin đợt nhập hàng
	public function show($id)
	{
		return StoreTranfer::with('detailStoreTranfers') -> find($id);
	}

	// API chỉnh sửa thông tin đợt nhập hàng
	public function update(Request $request, $id)
	{

	}

	// API xóa đợt nhập hàng
	public function destroy($id)
	{
		$deleted = StoreTranfer::with('detailStoreTranfers') -> find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	// API xác nhận chuyển kho
	public function confirm($id, $status)
	{
		$selected = StoreTranfer::find($id);
		// Nhập hàng vao kho, cập nhật số lượng
		if($status==3 && ($selected -> status) !=3) { //Nếu nhập hàng cập nhật số lượng trên toàn hệ thống và các kho hàng
			$rows = StoreTranfer::join('detail_store_tranfer', 'detail_store_tranfer.store_tranfer_id', '=', 'store_tranfer.id')
				-> where('store_tranfer.id', '=', $id)
				-> get(); //Lây chi tiết danh sách các mặt hàng cần nhập
			foreach ($rows as $row) {
				// Cập nhật hàng trong kho tương ứng
				$update = new ProductInStore();
				$update -> product_id = $row -> product_id;
				$update -> store_id = $row -> store_id;
				$update -> supplier_id = $row -> supplier_id;
				$update -> quantity = $row -> quantity;
				$update -> price = $row -> price;
				$update -> expried_date = $row -> expried_date;
				$update -> save();
			}
		}
		$selected -> status = $status;
		$selected -> save();
		return response()->json(['success' => trans('message.update_success')]);
	}

	// Xem lịch sử chuyển kho
	public function listStoreTranfer()
	{
		return view('store-tranfer.store-tranfer');
	}

	// Tạo đơn chuyển kho mới
	public function createStoreTranfer()
	{
		return view('store-tranfer.new-store-tranfer');
	}
}
