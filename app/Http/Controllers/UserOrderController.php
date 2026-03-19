<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class UserOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('items.product')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('orders.user_index', compact('orders'));
    }

    public function pay(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        if (in_array($order->status, ['paid', 'completed', 'cancelled'])) {
            return redirect()->route('user.orders')->with('error', 'El pedido ya está pagado o cancelado.');
        }

        // Cargar los items si no están cargados
        $order->load('items.product');

        return view('orders.user_pay', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $request->validate([
            'payment_method' => 'required|in:bank_transfer,stripe,paypal'
        ]);

        $order->update(['payment_method' => $request->payment_method]);

        if ($request->payment_method === 'bank_transfer') {
            $order->update(['status' => 'pending_transfer']);
            return response()->json([
                'success' => true,
                'redirect' => route('checkout.success', $order->id),
                'message' => 'Pedido actualizado. Por favor realice el pago por transferencia.'
            ]);
        }

        if ($request->payment_method === 'stripe') {
            return $this->processStripe($order);
        }

        if ($request->payment_method === 'paypal') {
            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Iniciando pago con PayPal...'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Método no soportado.'], 400);
    }

    private function processStripe(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'mxn',
                    'product_data' => [
                        'name' => $item->product ? $item->product->name : 'Producto Eliminado',
                    ],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', $order->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', $order->id),
            'client_reference_id' => $order->id,
        ]);

        return response()->json([
            'success' => true,
            'id' => $session->id,
            'url' => $session->url
        ]);
    }
}
