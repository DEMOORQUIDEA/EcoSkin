<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|string|in:pending,paid,cancelled',
            'shipping_status' => 'required|string|in:pending,shipped,delivered,cancelled'
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
            'shipping_status' => $request->shipping_status,
            // Sincronizar el status original para compatibilidad
            'status' => $request->shipping_status === 'cancelled' ? 'cancelled' : ($request->payment_status === 'paid' ? 'paid' : 'pending')
        ]);

        return redirect()->back()->with('success', 'Estados de pedido actualizados correctamente.');
    }
}
