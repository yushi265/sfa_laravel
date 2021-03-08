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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $progresses = Progress::with('customer', 'user')->latest()->limit(3)->get();
        $contracts = Contract::with('customer', 'contract_type')->latest()->limit(3)->get();
        return view('home')->with(['progresses' => $progresses, 'contracts' => $contracts]);
    }
}
