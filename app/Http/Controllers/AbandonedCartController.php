<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of abandoned products/carts.
     * Note: In this implementation, we currently rely on client-side storage,
     * so this view serves as a placeholder for future server-side tracking.
     */
    public function index()
    {
        return view('admin.abandoned.index');
    }
}
