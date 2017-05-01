<?php
/**
 * Created by PhpStorm.
 * User: ka
 * Date: 20/04/2017
 * Time: 09:05
 */

namespace App\Http\Controllers;


use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AddressController extends Controller
{

    public function index()
    {
        return Address::with('province', 'district', 'ward')->get();
    }

    public function show($id)
    {
        return Address::with('province', 'district', 'ward')->find($id);
    }

    public function store(Request $request)
    {
        $address = new Address();
        $address->customer_id = Input::get('customer_id');
        $address->phone_number = Input::get('phone_number');
        $address->province_id = Input::get('province_id');
        $address->ward_id = Input::get('ward_id');
        $address->detail = Input::get('detail');
        $address->district_id = Input::get('district_id');
        $address->save();

        return Address::find($address->id);
    }

    public function update(Request $request, $id)
    {
        $address = Address::find($id);

        $address->phone_number = Input::get('phone_number');
        $address->detail = Input::get('detail');
        $address->province_id = Input::get('province_id');
        $address->ward_id = Input::get('ward_id');
        $address->district_id = Input::get('district_id');
        $address->save();

        return Address::find($id);
    }


    public function destroy($id)
    {
        $address = Address::find($id)->delete();
        return "Xoa thanh cong";
    }

    public function listAddressByCustomerId($customerId)
    {
        $address = Address::where('customer_id', $customerId)->with('province', 'district', 'ward')
            ->orderBy('created_at', 'desc');
        return $address->get();
    }
}