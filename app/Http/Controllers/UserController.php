<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

//Model CSDL
use App\User;

class UserController extends Controller
{
    /**
     * API danh sách nhân viên
     */
    public function index()
    {
        return User::where('name', '<>', 'admin') -> get();
    }

    /**
     * API tạo nhân viên mới
     */
    public function store(Request $request)
    {
        // validate
        $rules = [
            'name' => 'required',
            'email' => 'email|unique:user,email|required',
            'pass' => 'min:6|required',
            'phone' => 'required',
            'address' => 'required',
            'work_place_id' => 'required',
            'position_id' => 'required'
        ];
        $validation = Validator::make(Input::all(), $rules);

        if($validation->fails())
            return $validation -> errors() -> all();
        else {
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
	        return response()->json(['success' => trans('message.create_success')]);
        }
    }

    /**
     * API xem thông tin nhân viên
     */
    public function show($id)
    {
        //
        return User::find($id);
    }

    /**
     * API chỉnh sửa thông tin nhân viên
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|distinct',
            'phone' => 'required',
            'address' => 'required',
            'work_place_id' => 'required',
            'position_id' => 'required'
        ];
        $validation = Validator::make(Input::all(), $rules);

        if($validation->fails())
            return $validation -> errors() -> all();
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
	        return response()->json(['success' => trans('message.update_success')]);
        }
    }

    /**
     * API xóa thông tin nhân viên
     */
    public function destroy($id)
    {
        $user = User::find($id) -> delete();
	    return response()->json(['success' => trans('message.delete_success')]);
    }

    /**
     * Xem danh sách nhân viên
     */
    public function listUser()
    {
        return view('user.user');
    }

    /**
     * Nhập thông tin nhân viên từ File Excel
     */
    public function importUserFromFile(Request $request)
    {

    }

	/**
	 * Download mẫu nhập
	 */
	public function downloadTemplate()
	{
		return response() -> download(public_path().'/template/nhan vien.xlsx');
	}
}