<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\DetailInputStore;
use App\InputStore;
use App\ProductInStore;
use App\Product;

class ReportController extends Controller
{
	public function getTopProduct() {
		$topProducts = DB::table('order_detail')
			-> selectRaw('product_id, sum(quantity) as sum')
			-> groupBy('product_id')
			-> orderBy('sum', 'desc')
			-> limit(10)
			-> get();
		return $topProducts;
	}

	public function getTopUser() {
		$topUsers = DB::table('order')
			// -> where('status', '=', 4)
			-> selectRaw('created_by, sum(total_paid) as sum')
			-> groupBy('created_by')
			-> orderBy('sum', 'desc')
			-> limit(10)
			-> get();
		return $topUsers;
	}

	public function getReportRevenue() {
		$sum01 = DB::table('voucher')
			-> selectRaw('type, total, created_at')
			-> where('type', '=', 0)
			-> where('created_at', '<=', Carbon::now())
			-> limit(10)
			-> get();
		$sum02 = DB::table('voucher')
			-> selectRaw('type, total, created_at')
			-> where('type', '=', 1)
			-> limit(10)
			-> get();
		return ['sum01' => $sum01, 'sum02' => $sum02];
	}

	public function getReportInputStore(Request $request) {
		$rules = [
			'store_id' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$data = InputStore::with('store')
				-> with('detailInputStores')
				-> with('user')
				-> with('supplier')
				-> with('account')
				-> where('store_id', '=', Input::get('store_id'))
				-> where('status', '=', 4)
				-> where('created_at', '<=', Carbon::parse(Input::get('end_date')))
				-> where('created_at', '>=', Carbon::parse(Input::get('start_date')))
				-> get();
			return response()->json(['success' => $data]);
		}
	}

	public function getReportProductInStore(Request $request) {
		$rules = [
			'store_id' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$data = ProductInStore::join('product', 'product_in_store.product_id', '=', 'product.id')
				-> with('store')
				-> with('supplier')
				-> with('unit')
				-> with('user')
				-> where('store_id', '=', Input::get('store_id'))
				-> where('product_in_store.created_at', '<=', Carbon::parse(Input::get('end_date')))
				-> where('product_in_store.created_at', '>=', Carbon::parse(Input::get('start_date')))
				-> get();
			return response()->json(['success' => $data]);
		}
	}

    public function productReport() {
    	return view('report.product');
    }

    public function userReport() {
    	return view('report.report-user');
    }

	public function revenueReport() {
		return view('report.report-revenue');
	}

	public function inputStoreReport() {
		return view('report.report-input-store');
	}

	public function productInStoreReport() {
		return view('report.report-product-in-store');
	}
}
