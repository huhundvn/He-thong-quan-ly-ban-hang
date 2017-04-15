<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show dashboard sale
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sale()
    {
        return view('menu.sale');
    }

    public function product()
    {
        return view('menu.product');
    }

    /**
     * Show dashboard customer
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customer()
    {
        return view('menu.customer');
    }

    /**
     * Show dashboard store
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store()
    {
        return view('menu.store');
    }

    /**
     * Show dashboard accountant
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accountant()
    {
        return view('menu.accountant');
    }

    /**
     * Show dashboard promotion
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promotion()
    {
        return view('menu.promotion');
    }

    /**
     * Show dashboard report
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report()
    {
        return view('menu.report');
    }

    /**
     * Show dashboard user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user()
    {
        return view('menu.user');
    }
}
