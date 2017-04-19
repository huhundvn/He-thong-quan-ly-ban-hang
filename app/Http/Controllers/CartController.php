<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cart;

class CartController extends Controller
{
	public function index()
	{
		return Cart::all();
	}

	public function show($id)
	{
		return Cart::find($id);
	}


	public function listCartByCustomerId($customerId)
	{
		return Cart::Where('customer_id', $customerId)->orderBy('created_at')->get();
	}

	public function update(Request $request)
	{
		$cart = new Cart();
	}

	public function destroy($id)
	{
		$cart = Cart::find($id)->delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	public function store(Request $request)
	{
		$cart = new Cart();
		$cart->customer_id = Input::get('customer_id');
		$cart->product_id = Input::get('product_id');
		$cart->quantity = Input::get('quantity');
		$cart->save();
		return response()->json(['success' => trans('message.create_success')]);
	}

	public function updateCartByCustomerId($customerId, $productId)
	{
		$cart = Cart::Where('customer_id', $customerId)->where('product_id', $productId)->firstOrFail();

		$cart->quantity = Input::get('quantity');
		$cart->save();
		return Cart::find($cart->id);
	}

	public function deleteCartByCustomerId($customerId)
	{
		$cart = Cart::where('customer_id', $customerId)->get();
		foreach ($cart as $item) {
			$item->delete();
		}
		return "Delete thanh cong";
	}
}
