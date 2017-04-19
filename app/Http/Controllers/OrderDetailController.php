<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
	public function index()
	{
		return OrderDetail::all();
	}

	public function store(Request $request)
	{
		$orderDetail = new OrderDetail();

		$orderDetail->order_id = Input::get('order_id');
		$orderDetail->product_id = Input::get('product_id');
		$orderDetail->quantity = Input::get('quantity');
		$orderDetail->total = Input::get('total');
		$orderDetail->save();

		return OrderDetail::find($orderDetail->id);
	}

	public function listOrderDetailByOrderId($orderId)
	{
		$orderDetail = OrderDetail::Where('order_id', $orderId);
		return $orderDetail->get();
	}

	public function updateOrderDetailByProductId($orderId, $productId)
	{
		$orderDetail = OrderDetail::Where('order_id', $orderId)->where('product_id', $productId)->firstOrFail();
		$orderDetail->quantity = Input::get('quantity');
		$orderDetail->total = Input::get('total');
		$orderDetail->save();

		return OrderDetail::find($orderId);
	}
}
