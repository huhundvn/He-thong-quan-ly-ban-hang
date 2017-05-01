<?php
/**
 * Created by PhpStorm.
 * User: ka
 * Date: 16/04/2017
 * Time: 15:15
 */

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class CartController extends Controller
{

    public function index()
    {
        return Cart::all();
    }

    public function show($id)
    {
        return Cart::with('product')->find($id);
    }


    public function listCartByCustomerId($customerId)
    {
        return Cart::Where('customer_id', $customerId)->with('product')->orderBy('created_at', 'desc')->get();
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
        $cart->price_output = Input::get('price_output');
        $cart->save();
        return Cart::with('product')->find($cart->id);
    }

    public function updateCartByCustomerId($customerId, $productId)
    {
        $cart = Cart::Where('customer_id', $customerId)->where('product_id', $productId)->firstOrFail();

        $cart->quantity = Input::get('quantity');
        $cart->price_output = Input::get('price_output');
        $cart->save();
        return Cart::find($cart->id);
    }

    public function deleteCartByCustomerId($customerId)
    {
        $cart = Cart::where('customer_id', $customerId)->get();
        foreach ($cart as $item) {
            $item->delete();
        }
        return Cart::get();
    }

    public function deleteProductInCart($customerId, $productId)
    {
        $cart = Cart::Where('customer_id', $customerId)->where('product_id', $productId)->firstOrFail();
        $cart->delete();
        return $this->listCartByCustomerId($customerId);
    }
}