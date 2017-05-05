<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

class ReportController extends Controller
{
	public function getTopProduct() {
		$topProducts = Product::join('order_detail', 'order_detail.product_id', '=', 'product.id')
			-> get();
		return $topProducts;
	}

    public function productReport() {
    	return view('report.product');
    }

	public function inputStoreReport() {
		return view('report.report-input-store');
	}
}
