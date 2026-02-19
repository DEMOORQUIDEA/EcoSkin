<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('security:auth');
    }

    /**
     * Display the shopping cart page.
     */
    public function index()
    {
        return view('cart.index');
    }
}
