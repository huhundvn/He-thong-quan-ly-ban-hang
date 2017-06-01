<?php

namespace App\Http\Controllers;

use App\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\Order;
use App\Voucher;
use App\Customer;
use App\Account;

class OrderController extends Controller
{
	// API lấy danh sách đơn hàng
	public function index()
	{
		return Order::with('orderDetails')
			-> with('user')
			-> with('customer')
			-> with('priceOutput')
			-> get();
	}

	//API tìm kiếm đơn hàng theo khoảng thời gian
	public function search(Request $request)
	{
		return Order::with('orderDetails')
			-> with('user')
			-> with('customer')
			-> with('priceOutput')
			-> where('created_at', '<=', Carbon::parse(Input::get('end_date')))
			-> where('created_at', '>=', Carbon::parse(Input::get('start_date')))
			-> get();
	}


	// API lấy danh sách đơn hàng hôm nay
	public function getTodayOrder() {
		return count(
				Order::where('status', '=', 1)
					-> where('created_at', '>=', Carbon::yesterday())
					-> where('created_at', '<=', Carbon::now())
					-> get()
			);
	}

	// API lấy danh sách đơn hàng cần xuất giao
	public function getShipOrder()
	{
		return Order::with('orderDetails')
			-> with('user')
			-> with('customer')
			-> with('priceOutput')
			-> where('status', '=', 2)
			-> get();
	}

	// API lấy danh sách đơn hàng đã thanh toán
	public function getPaidOrder()
	{
		return Order::with('orderDetails')
			-> with('user')
			-> with('customer')
			-> with('priceOutput')
			-> orWhere('status', '=', 3)
			-> orWhere('status', '=', 4)
			-> get();
	}

	// API tạo đơn hàng mới
	public function store(Request $request)
	{
		$rules = [
			'customer_id' => 'required',
			'payment_method' => 'required',
			'account_id' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new Order();
			$new -> created_by = Auth::user() -> id;
			$new -> customer_id = Input::get('customer_id');

			$new -> price_output_id = Input::get('price_output_id');

			$new -> payment_method = Input::get('payment_method');
			$new -> bank = Input::get('bank');
			$new -> bank_account = Input::get('bank_account');
			$new -> account_id = Input::get('account_id');

			$new -> contact_name = Input::get('contact_name');
			$new -> contact_address = Input::get('contact_address');
			$new -> contact_phone = Input::get('contact_phone');
			$new -> total = Input::get('total');
			$new -> total_paid = Input::get('total_paid');

			$new -> tax = Input::get('tax');
			$new -> discount = Input::get('discount');

			$new -> status = 1;
			$new -> save();
			return response()->json(['success' => ($new->id)]);
		}
	}

	// API lấy thông tin đơn hàng
	public function show($id)
	{
		return Order::with('orderDetails')
			-> with('user')
			-> with('customer')
			-> with('priceOutput')
			-> find($id);
	}

	// API chỉnh sửa đơn hàng
    public function update(Request $request, $id)
    {
	    // kiểm tra điều kiện
	    $rules = [

	    ];
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails())
		    return $validation -> errors() -> all();
	    else {
	    	$update = Order::find($id);
		    $customer = Customer::find($update -> customer_id);
	    	$update -> total_paid = $update -> total_paid + Input::get('total_paid');
		    $update -> save();

		    $voucher  = new Voucher();
		    $voucher -> created_by = Auth::user() -> id;
		    $voucher -> description = "Thanh toán đơn hàng DH-".$id;
		    $voucher -> total = Input::get('more_paid');
		    $voucher -> type = 0;
		    $voucher -> name = $customer -> name;
		    $voucher -> address = $customer -> address;
		    $voucher -> save();

		    return response()->json(['success' => trans('message.update_success')]);
	    }
    }

	// API xóa đơn hàng
	public function destroy($id)
	{
		$deleted = Order::find($id) -> delete();
		OrderDetail::where('order_id', '=', $id) -> delete();
		return response()->json(['success' => 'Xóa đơn hàng thành công']);
	}

	// API xác nhận đơn hàng
	public function confirm($id, $status)
	{
		$selected = Order::find($id);
		if($status == 4 && $selected -> status != 4) {
			$account = Account::find($selected -> account_id);
			$account -> total += $selected -> total_paid;
			$account -> save();

			$customer = Customer::find($selected -> customer_id);

			$voucher  = new Voucher();
			$voucher -> created_by = Auth::user() -> id;
			$voucher -> description = "Thanh toán đơn hàng DH-".$id;
			$voucher -> total = $selected -> total_paid;
			$voucher -> type = 0;
			$voucher -> name = $customer -> name;
			$voucher -> address = $customer -> address;
			$voucher -> save();
		}
		$selected -> status = $status;
		$selected -> save();
		return response()->json(['success' => trans('message.update_success')]);
	}

	// Xem lịch sử đơn hàng
	public function listOrder()
	{
		return view('order.order');
	}

	// Tạo đơn nhập hàng mới
	public function createOrder()
	{
		return view('order.new-order');
	}
}
