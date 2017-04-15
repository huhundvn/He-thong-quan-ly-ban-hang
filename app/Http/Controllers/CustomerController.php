<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//Model CSDL
use App\Customer;
use App\Bank;
use App\CustomerGroup;

class CustomerController extends Controller
{
    /**
     * API lây danh sách khách hàng
     */
    public function index()
    {
	    return Customer::all();
    }

    /**
     * API thêm khách hàng mới
     */
    public function store(Request $request)
    {
	    $rules = [
		    'name' => 'required',
		    'email' => 'email|unique:customer,email|required',
		    'phone' => 'required',
		    'address' => 'required',
		    'bank' => 'required_with:bank_account',
	    ];
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails())
		    return $validation -> errors() -> all();
	    else {
		    $customer = new Customer;
		    $customer -> name = Input::get('name');
		    $customer -> email = Input::get('email');
		    $customer -> phone = Input::get('phone');
		    $customer -> address = Input::get('address');
		    $customer -> bank_account = Input::get('bank_account');
		    $customer -> bank = Input::get('bank');
		    $customer -> customer_group_id = Input::get('customer_group_id');
		    $customer -> note = Input::get('note');
		    $saved = $customer -> save();
		    return response()->json(['success' => trans('message.create_success')]);

	    }
    }

    /**
     * API xem thông tin khách hàng
     */
    public function show($id)
    {
	    return Customer::find($id);
    }

    /**
     * API sửa thông tin khách hàng
     */
    public function update(Request $request, $id)
    {
	    $rules = [
		    'name' => 'required',
		    'email' => 'email|required|distinct',
		    'phone' => 'required',
		    'address' => 'required',
		    'bank_account' => 'distinct|required',
		    'bank' => 'required_with:bank_account',
	    ];
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails())
		    return $validation -> errors() -> all();
	    else {
		    $customer = Customer::find(Input::get('id'));
		    $customer -> name = Input::get('name');
		    $customer -> email = Input::get('email');
		    $customer -> phone = Input::get('phone');
		    $customer -> address = Input::get('address');
		    $customer -> bank_account = Input::get('bank_account');
		    $customer -> bank = Input::get('bank_id');
		    $customer -> customer_group_id = Input::get('customer_group_id');
		    $customer -> note = Input::get('note');
		    $customer -> save();
		    return response()->json(['success' => trans('message.update_success')]);
	    }
    }

    /**
     * API xóa thông tin khách hàng
     */
    public function destroy($id)
    {
	    $customer = Customer::find($id) -> delete();
	    return response()->json(['success' => trans('message.delete_success')]);
    }

    /**
     * Xem danh sách nhân viên
     */
    public function listCustomer()
    {
        return view('customer.customer');
    }

    /**
     * Tìm kiếm nhân viên
     */
    public function searchCustomer($term)
    {
        return Customer::where('name', 'LIKE', '%'. $term . '%') -> get();
    }

    /**
     * Nhập thông tin khách hàng từ File Excel
     */
    public function importFromFile(Request $request)
    {
	    // kiểm tra điều kiện nhập
	    $rules = [
		    'ten_khach_hang' => 'required',
		    'email' => 'unique:customer,email|required',
		    'so_dien_thoai' => 'required',
		    'dia_chi' => 'required',
		    'tai_khoan_ngan_hang' => 'unique:customer,bank_account|required',
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
			        $newCustomer = new Customer;
			        $newCustomer -> name = $row -> ten_khach_hang;
			        $newCustomer -> address = $row -> dia_chi;
			        $newCustomer -> phone = $row -> so_dien_thoai;
			        $newCustomer -> email = $row -> email;
			        $newCustomer -> bank_account = $row -> tai_khoan_ngan_hang;
			        $newCustomer -> bank_id = Bank::where('name', '=', $row -> ngan_hang)->pluck('id')->first();
			        $newCustomer -> customer_group_id = CustomerGroup::where('name', '=', $row -> nhom_khach_hang)->pluck('id')->first();
			        $newCustomer -> note = $row -> ghi_chu;
			        $saved = $newCustomer -> save();
			        if(!$saved)
			    	    continue;
			        if($saved)
			        	$count++;
			    }
 		    }
 		    return redirect()->route('list-customer') -> with('status', 'Đã thêm '.$count.' mục.');
    	}
    }

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/khach hang.xlsx');
	}
}
