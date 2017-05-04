<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function getRole() {
	    $user = User::with('position') -> find(Auth::user() -> id);
	    $roles = json_decode($user -> position -> role);
	    return $roles;
    }
}
