<?php

namespace App\Http\Controllers;

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
		return Order::with('orderDetails') -> get();
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

			$new -> payment_method = Input::get('payment_method');
			$new -> bank = Input::get('bank');
			$new -> bank_account = Input::get('bank_account');
			$new -> account_id = Input::get('account_id');

			$new -> contact_name = Input::get('contact_name');
			$new -> contact_address = Input::get('contact_address');
			$new -> contact_phone = Input::get('contact_phone');
			$new -> total = Input::get('total');
			$new -> total_paid = Input::get('total_paid');
			$new -> status = 1;
			$new -> save();
			return response()->json(['success' => ($new->id)]);
		}
	}

	// API lấy thông tin đơn hàng
	public function show($id)
	{
		return Order::with('orderDetails') -> find($id);
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

	// Xem đơn hàng theo khách hàng
//	public function orderByCustomerId($customerId)
//    {
//        $order = Order::Where('customer_id', '=', $customerId)->with('orderDetails')->orderBy('created_at', 'desc');
//        return $order->get();
//    }

    // Xác nhận đơn hàng
//    public function update($id)
//    {
//        $order = Order::find($id);
//        $order->status = Input::get('status');
//        $order->save();
//        return Order::find($id);
//    }
//
//     Update đơn hàng theo id customer
//    public function updateStatus($id, $customerId)
//    {
//        $order = Order::Where('id', '=', $id, 'AND', 'customer_id', '=', $customerId)->firstOrFail();
//        $order->status = Input::get('status');
//        $order->save();
//        return response()->json(['success' => trans('message.update_success')]);
//        return Order::find($id);
//    }
//
//     xem danh sách đơn hàng cho admin
//    public function listOrderByStatus($status)
//    {
//        $order = Order::Where('status', $status)->with('orderDetails')->orderBy('created_at', 'desc');
//        return $order->get();
//    }
//
//     xem danh sách đơn hàng theo khách hàng
//    public function listOrderByStatusAndCustomerId($status, $customerId)
//    {
//        $order = Order::Where('status', $status)->where('customer_id', $customerId)->with('orderDetails')->orderBy('created_at', 'desc');
//        return $order->get();
//    }
}
