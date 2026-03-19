<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the "Nosotros" (About Us) page.
     */
    public function nosotros()
    {
        return view('nosotros');
    }
}
