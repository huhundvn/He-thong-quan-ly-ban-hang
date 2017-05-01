<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//Model CSDL
use App\User;

class UserController extends Controller
{
    // API lấy danh sách nhân viên
    public function index()
    {
        return User::all();
    }

    // API tạo nhân viên mới
    public function store(Request $request)
    {
        // kiểm tra điều kiện nhập
        $rules = [
            'name' => 'required', // nhập tên
            'email' => 'email|unique:user,email|required', // nhập email, không trùng email đã tồn tại
            'pass' => 'min:6|required', // nhập mật khẩu, tối thiểu 6 kí tự
            'phone' => 'required', // nhập số điện thoại
            'address' => 'required', // nhập địa chỉ
            'position_id' => 'required' // nhập chức vụ
        ];
        $validation = Validator::make(Input::all(), $rules);

        if($validation->fails())
            return $validation -> errors() -> all(); // nếu có lỗi trả về lỗi
        else {
        	// tạo nhân viên mới
            $user = new User();
            $user -> name = Input::get('name');
            $user -> email = Input::get('email');
	        $user -> password = bcrypt(Input::get('pass'));
            $user -> phone = Input::get('phone');
            $user -> address = Input::get('address');
            $user -> work_place_id = Input::get('work_place_id');
            $user -> position_id = Input::get('position_id');
            $user -> status = 1;
            $user -> save();
	        return response()->json(['success' => 'Đã tạo nhân viên mới thành công.']);
        }
    }

    // API xem thông tin nhân viên
    public function show($id)
    {
        return User::find($id);
    }

    // API chỉnh sửa thông tin nhân viên
    public function update(Request $request, $id)
    {
    	// kiểm tra điều kiện nhập
        $rules = [
            'name' => 'required', //nhập tên
            'email' => 'required|email|distinct', //nhập email, không tồn tại
            'phone' => 'required', //nhập số điện thoại
            'address' => 'required', //nhập địa chỉ
            'work_place_id' => 'required', //nhập nơi làm việc
            'position_id' => 'required' //nhập quyền
        ];
        $validation = Validator::make(Input::all(), $rules);

        if($validation->fails())
            return $validation -> errors() -> all(); //kiểm tra nếu có lỗi trả về lỗi
        else {
            $user = User::find($id);
            $user -> name = Input::get('name');
            $user -> email = Input::get('email');
            $user -> phone = Input::get('phone');
            $user -> address = Input::get('address');
            $user -> work_place_id = Input::get('work_place_id');
            $user -> position_id = Input::get('position_id');
            $user -> status = Input::get('status');
            $user -> save();
	        return response()->json(['success' => 'Chỉnh sửa thông tin thành công.']);
        }
    }

    //API xóa thông tin nhân viên
    public function destroy($id)
    {
        $user = User::find($id) -> delete();
	    return response()->json(['success' => 'Đã xóa nhân viên.']);
    }

    // Danh sách nhân viên trên Web
    public function listUser()
    {
        return view('user.user');
    }

    // Nhập thông tin nhân viên từ file Excel
    public function importUserFromFile(Request $request)
    {

    }

	// Download mẫu nhập
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/nhan vien.xlsx');
	}

	// Đổi mật khẩu
	public function changePassword(Request $request)
	{
		// kiểm tra điều kiện nhập
		$rules = [
			'old_pass' => 'required',
			'new_pass' => 'unique:product,code',
			'confirm_pass' => 'required',
		];

		$new = User::find(Auth::user() -> id);
		$new -> password = bcrypt(Input::get('new_pass'));
		$new -> save();
		return redirect() -> route('home');
	}
}