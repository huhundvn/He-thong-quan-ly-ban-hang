<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

//MODEL CSDL
use App\CustomerGroup;

class CustomerGroupController extends Controller
{
    /**
     * API danh sách nhóm khách hàng
     */
    public function index()
    {
	    return CustomerGroup::all();
    }

    /**
     * API tạo nhóm khách hàng mới
     */
    public function store(Request $request)
    {
	    $rules = [
		    'name' => 'required|unique:customer_group,name',
	    ];
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails())
		    return $validation -> errors() -> all();
	    else {
		    $groupCustomer = new CustomerGroup();
		    $groupCustomer -> name = Input::get('name');
		    $groupCustomer -> description = Input::get('description');
		    $groupCustomer -> save();
	    }
	    return response()->json(['success' => trans('message.create_success')]);
    }

    /**
     * API hiển thị thông tin nhóm khách hàng
     */
    public function show($id)
    {
	    return CustomerGroup::find($id);
    }

    /**
     * API chỉnh sửa nhóm khách hàng
     */
    public function update(Request $request, $id)
    {
	    $rules = [
		    'name' => 'required|distinct',
	    ];
	    $validation = Validator::make(Input::all(), $rules);

	    if($validation->fails())
		    return $validation -> errors() -> all();
	    else {
		    $customerGroup = CustomerGroup::find($id);
		    $customerGroup -> name = Input::get('name');
		    $customerGroup -> description = Input::get('description');
		    $customerGroup -> save();
	    }
	    return response()->json(['success' => trans('message.update_success')]);
    }

    /**
     * API xóa nhóm khách hàng
     */
    public function destroy($id)
    {
	    $customerGroup = CustomerGroup::find($id) -> delete();
	    return response()->json(['success' => trans('message.delete_success')]);
    }

	/**
	 * Xem danh sách nhóm khách hàng
	 */
	public function listGroupCustomer()
	{
		return view('customer.customer-group');
	}

	/**
	 * Tìm kiếm nhóm khách hàng
	 */
	public function searchCustomerGroup($term)
	{
		return CustomerGroup::where('name', 'LIKE', '%'. $term . '%') -> get();
	}

	/**
	 * Nhập thông tin khách hàng từ File Excel
	 */
	public function importFromFile(Request $request)
	{
		// kiểm tra điều kiện nhập
		$rules = [
			'ten_nhom' => 'required|unique:customer_group,name',
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
			return redirect()->route('list-customer-group') -> with('status', 'Đã thêm '.$count.' mục.');
		}
	}

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/nhom khach hang.xlsx');
	}
}
