<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Store;

class StoreController extends Controller
{
    /**
     * API lấy danh sách cửa hàng
     */
    public function index()
    {
	    return Store::all();
    }

    /**
     * API tạo cửa hàng mới
     */
    public function store(Request $request)
    {
	    $rules = [
		    'name' => 'required|distinct',
		    'email' => 'required|email|distinct',
		    'phone' => 'required',
		    'address' => 'required',
		    'type' => 'required',
	    ];
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails())
		    return $validation -> errors() -> all();
	    else {
		    $store = new Store();
		    $store -> name = Input::get('name');
		    $store -> email = Input::get('email');
		    $store -> phone = Input::get('phone');
		    $store -> address = Input::get('address');
//		    $store -> managed_by = Input::get('managed_by');
		    $store -> type = Input::get('type');
		    $store -> store_id = Input::get('store_id');
		    $store -> status = 1;
		    $store -> save();
		    return response()->json(['success' => trans('message.create_success')]);
	    }
    }

    /**
     * API lấy thông tin một cửa hàng
     */
    public function show($id)
    {
	    return Store::find($id);
    }

    /**
     * API chỉnh sửa thông tin một cửa hàng
     */
    public function update(Request $request, $id)
    {
	    $rules = [
		    'name' => 'required|distinct',
		    'email' => 'required|distinct',
		    'phone' => 'required',
		    'address' => 'required',
		    'type' => 'required',
		    'status' => 'required'
	    ];
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails())
		    return $validation -> errors() -> all();
	    else {
		    $update = Store::find(Input::get('id'));
		    $update -> name = Input::get('name');
		    $update -> email = Input::get('email');
		    $update -> phone = Input::get('phone');
		    $update -> address = Input::get('address');
//		    $update -> managed_by = Input::get('managed_by');
		    $update -> type = Input::get('type');
		    $update -> store_id = Input::get('store_id');
		    $update -> status = Input::get('status');
		    $update -> save();
		    return response()->json(['success' => trans('message.update_success')]);
	    }
    }

    /**
     * API xóa thông tin 1 cửa hàng
     */
    public function destroy($id)
    {
	    $store = Store::find($id) -> delete();
	    return response()->json(['success' => trans('message.delete_success')]);
    }

	/**
	 * Xem danh sách cửa hàng
	 */
	public function listStore()
	{
		return view('store.store');
	}

	/**
	 * Lấy danh sách các kho hàng
	 */
	public function getStorage()
	{
		return Store::where('type', '=', '0') -> get();
	}

	/**
	 * Nhập từ file Excel
	 */
	public function importFromFile(Request $request)
	{
		$rules = [
			'ten' => 'required|unique:store,name',
			'so_dien_thoai' => 'required',
			'dia_chi' => 'required',
			'loai' => 'required',
		];

		if(Input::hasFile('file')) {
			$rows =  Excel::load(Input::file('file'), function ($reader){},'UTF-8') -> get();
			$count = 0;
			foreach ($rows as $row) {
				$validation = Validator::make($row->toArray(), $rules);
				if($validation->fails())
					continue;
				else {
					$new = new Store();
					$new -> name = $row -> ten;
					$new -> phone = $row -> so_dien_thoai;
					$new -> address = $row -> dia_chi;
//					$new -> managed_by = User::where('name', '=', $row -> quan_ly_boi) ->;
					$new -> email = $row -> email;
					if($row -> loai == 'Cửa hàng')
						$new -> type =  1;
					if($row -> loai == 'Kho')
						$new -> type =  0;
					$new -> status = 1;
					$saved = $new -> save();
					if(!$saved)
						continue;
					else
						$count++;
				}
			}
			return redirect()->route('list-store') -> with('status', 'Đã thêm '.$count.' mục.');
		}
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/kho.xlsx');
	}
}
