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
		    return response()->json(['success' => trans('message.create_success')]);
	    }
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
		    return response()->json(['success' => trans('message.update_success')]);
	    }
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
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/nhom khach hang.xlsx');
	}
}
