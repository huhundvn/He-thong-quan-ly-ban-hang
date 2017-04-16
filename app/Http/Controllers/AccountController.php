<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//Model CSDL
use App\Account;


class AccountController extends Controller
{
	/**
	 * API lấy danh sách tài khoản
	 */
	public function index()
	{
		return Account::all();
	}

	/**
	 * API tạo tài khoản thanh toán mới
	 */
	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|unique:account,name',
			'total' => 'required',
			'bank_account' => 'required_with:bank',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = new Account();
			$new -> name = Input::get('name');
			$new -> bank_account = Input::get('bank_account');
			$new -> bank = Input::get('bank');
			$new -> total = Input::get('total');
			$new -> save();
			return response()->json(['success' => trans('message.create_success')]);
		}
	}

	/**
	 * API lấy thông tin tài khoản mới
	 */
	public function show($id)
	{
		return Account::find($id);
	}

	/**
	 * API chỉnh sửa thông tin tài khoản
	 */
	public function update(Request $request, $id)
	{
		$rules = [
			'name' => 'required|distinct',
			'total' => 'required',
			'bank' => 'required_with:bank_account',
		];
		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
			return $validation -> errors() -> all();
		else {
			$new = Account::find($id);
			$new -> name = Input::get('name');
			$new -> bank_account = Input::get('bank_account');
			$new -> bank = Input::get('bank');
			$new -> total = Input::get('total');
			$new -> save();
			return response()->json(['success' => trans('message.update_success')]);
		}
	}

	/**
	 * API xóa thông tin một đơn vị tính
	 */
	public function destroy($id)
	{
		$account = Account::find($id) -> delete();
		return response()->json(['success' => trans('message.delete_success')]);
	}

	/**
	 * Xem danh sách tài khoản
	 */
	public function listAccount()
	{
		return view('account.account');
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/tai khoan.xlsx');
	}
}
