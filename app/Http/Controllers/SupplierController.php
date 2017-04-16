<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//MODEL CSDL
use App\Supplier;


class SupplierController extends Controller
{
    /**
     * API lấy danh sách nhà cung cấp
     */
    public function index()
    {
	    return Supplier::all();
    }

	/**
	 * API tạo nhà cung cấp mới
	 */
	public function store(Request $request)
	{
		// validate
		$rules = [
			'name' => 'required|unique:supplier,name',
			'phone' => 'required',
			'address' => 'required',
			'person_contact' => 'required',
			'email' => 'required|email|unique:supplier,email',
			'bank' => 'required_with:bank_account',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$supplier = new Supplier();
			$supplier -> name = Input::get('name');
			$supplier -> phone = Input::get('phone');
			$supplier -> address = Input::get('address');
			$supplier -> bank_account = Input::get('bank_account');
			$supplier -> bank = Input::get('bank');
			$supplier -> person_contact = Input::get('person_contact');
			$supplier -> email = Input::get('email');
			$supplier -> note = Input::get('note');
			$supplier -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin nhà cung cấp
	 */
	public function show($id)
	{
		//
		return Supplier::find($id);
	}

	/**
	 * API chỉnh sửa thông tin nhà cung cấp
	 */
	public function update(Request $request, $id)
	{
		// validate
		$rules = [
			'name' => 'required|distinct',
			'phone' => 'required',
			'address' => 'required',
			'person_contact' => 'required',
			'email' => 'required|email|distinct',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$supplier = Supplier::find($id);
			$supplier -> name = Input::get('name');
			$supplier -> phone = Input::get('phone');
			$supplier -> address = Input::get('address');
			$supplier -> bank_account = Input::get('bank_account');
			$supplier -> bank = Input::get('bank');
			$supplier -> person_contact = Input::get('person_contact');
			$supplier -> email = Input::get('email');
			$supplier -> note = Input::get('note');
			$supplier -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	/**
	 * API xóa thông tin một nhà cung cấp
	 */
	public function destroy($id)
	{
		//
		$store = Supplier::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách nhà cung cáp
	 */
	public function listSupplier()
	{
		return view('supplier.supplier');
	}

	/**
	 * Nhập từ file Excel
	 */
	public function importFromFile(Request $request)
	{
		$rules = [
			'ten_nha_cung_cap' => 'required|unique:supplier,name',
			'so_dien_thoai' => 'required',
			'dia_chi' => 'required',
			'nguoi_lien_he' => 'required',
			'email' => 'required|email|unique:supplier,email',
			'ngan_hang' => 'required_with:tai_khoan_ngan_hang',
		];

		if(Input::hasFile('file')) {
			$rows =  Excel::load(Input::file('file'), function ($reader){
			},'UTF-8') -> get();
			$count = 0;
			foreach ($rows as $row) {
				$validation = Validator::make($row->toArray(), $rules);
				if($validation->fails())
					continue;
				else {
					$new = new Supplier();
					$new -> name = $row -> ten_nha_cung_cap;
					$new -> phone = $row -> so_dien_thoai;
					$new -> address = $row -> dia_chi;
					$new -> person_contact = $row -> nguoi_lien_he;
					$new -> email = $row -> email;
					$new -> bank_account = $row -> tai_khoan_ngan_hang;
					$new -> bank = $row -> ngan_hang;
					$new -> note = $row -> ghi_chu;
					$saved = $new -> save();
					if(!$saved)
						continue;
					else
						$count++;
				}
			}
			return redirect()->route('list-supplier') -> with('status', 'Đã thêm '.$count.' mục.');
		}
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/nha cung cap.xlsx');
	}
}