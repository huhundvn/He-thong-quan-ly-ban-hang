<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//MODEL CSDL
use App\District;

class DistrictController extends Controller
{
	/**
	 * API lấy danh sách huyện
	 */
	public function index()
	{
		return District::all();
	}
}
