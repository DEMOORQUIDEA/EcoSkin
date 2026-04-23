<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportAdminController extends Controller
{
    public function index(Request $request)
    {
        $validStatuses = ['paid', 'completed'];

        // Ventas del día (Hoy)
        $salesToday = Order::whereIn('status', $validStatuses)
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        // Ventas de la semana (Esta semana)
        $salesWeek = Order::whereIn('status', $validStatuses)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total');

        // Ventas del mes
        $salesMonth = Order::whereIn('status', $validStatuses)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

        // Total histórico de ventas
        $salesTotal = Order::whereIn('status', $validStatuses)->sum('total');

        // Orders de hoy para mostrar historial reciente
        $recentOrders = Order::with('user')
            ->whereIn('status', $validStatuses)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.index', compact('salesToday', 'salesWeek', 'salesMonth', 'salesTotal', 'recentOrders'));
    }
}
