<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    $user = User::with('position') -> find(Auth::user() -> id);
	    $roles = json_decode($user -> position -> role);
	    if(in_array('user', $roles))
		    return $next($request);
	    else
		    return redirect() -> route('no-permission');
    }
}
