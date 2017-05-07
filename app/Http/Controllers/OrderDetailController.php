<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\OrderDetail;

class OrderDetailController extends Controller
{
	public function index()
	{
		return OrderDetail::all();
	}

	public function store(Request $request)
	{
		$orderDetail = new OrderDetail();
		$orderDetail -> order_id = Input::get('order_id');
		$orderDetail -> product_id = Input::get('id');
//		$orderDetail -> unit_id = Input::get('unit_id');
		$orderDetail -> price = Input::get('web_price');
		$orderDetail -> quantity = Input::get('quantity');
		$orderDetail -> save();

		return OrderDetail::find($orderDetail->id);
	}

	// Xem chi tiết chuyển kho
	public function getDetail($orderID)
	{
		return OrderDetail::join('product', 'order_detail.product_id', '=', 'product.id')
			-> where('order_detail.order_id', '=', $orderID)
			-> with('unit')
			-> get();
	}

//	// Xem danh sách chi tiết đơn hàng
//	public function listOrderDetailByOrderId($orderId)
//	{
//		$orderDetail = OrderDetail::Where('order_id', $orderId)->with('product')->orderBy('created_at', 'desc');
//		return $orderDetail->get();
//	}
//
//	public function updateOrderDetailByProductId($orderId, $productId)
//	{
//		$orderDetail = OrderDetail::Where('order_id', $orderId)->where('product_id', $productId)->firstOrFail();
//		$orderDetail->quantity = Input::get('quantity');
//		$orderDetail->total = Input::get('total');
//		$orderDetail->save();
//
//		return OrderDetail::find($orderId);
//	}
}
