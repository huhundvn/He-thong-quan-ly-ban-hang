<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
	public function index()
	{
		return Order::with('orderDetails')->get();
	}

	public function show($id)
	{
		return Order::with('orderDetails')->find($id);
	}

	public function orderByCustomerId($customerId)
	{
		$order = Order::Where('customer_id', '=', $customerId);
		return $order->get();
	}

	public function store(Request $request)
	{
		$order = new Order();
		$order->customer_id = Input::get('customer_id');
		$order->customer_group_id = Input::get('customer_group_id');
		$order->name = Input::get('name');
		$order->email = Input::get('email');
		$order->address = Input::get('address');
		$order->phone = Input::get('phone');
		$order->total = Input::get('total');
		$order->status = Input::get('status', '0');
		$order->created_by = Input::get('created_by');
		$order->save();
		return Order::find($order->id);
	}

	public function update($id)
	{
		$order = Order::find($id);
		$order->status = Input::get('status');
		$order->save();
		return Order::find($id);
	}

	public function destroy($id)
	{
		$order = Order::find($id)->delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	public function updateStatus($id, $customerId)
	{
		$order = Order::Where('id', '=', $id, 'AND', 'customer_id', '=', $customerId)->firstOrFail();
		$order->status = Input::get('status');
		$order->save();
//        return response()->json(['success' => trans('message.update_success')]);
		return Order::find($id);
	}
}
