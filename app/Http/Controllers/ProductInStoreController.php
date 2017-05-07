<?php

namespace App\Http\Controllers;

use App\ProductInStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Product;

class ProductInStoreController extends Controller
{
	// API LẤY DANH SÁCH SẢN PHẨM TRONG KHO
	public function index()
	{
		return ProductInStore::join('product', 'product_in_store.product_id', '=', 'product.id')
			-> with('store')
			-> with('supplier')
			-> with('unit')
			-> with('user')
			-> get();
	}

	// XEM DANH SÁCH SẢN PHẨM TRONG KHO
	public function listProductInStore()
	{
		return view('product-in-store.product-in-store');
	}
}
