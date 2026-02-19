<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("security:auth");
    }

    /**
     * Show the application dashboard with search and pagination.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Búsqueda
        $search = $request->input('search', '');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%");
            });
        }

        // Paginación (12 productos por página)
        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Mantener parámetros de búsqueda en la paginación
        $products->appends(['search' => $search]);

        // Estadísticas generales (sin filtro)
        $allProducts = Product::all();

        return view("home", [
            'products' => $products,
            'search' => $search,
            'totalProducts' => $allProducts->count(),
            'avgPrice' => $allProducts->avg('price') ?? 0,
        ]);
    }
}
