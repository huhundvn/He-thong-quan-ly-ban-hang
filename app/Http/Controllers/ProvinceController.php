<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//MODEL CSDL
use App\Province;

class ProvinceController extends Controller
{
	/**
	 * API lấy danh sách tỉnh
	 */
	public function index()
	{
		return Province::all();
	}
}
