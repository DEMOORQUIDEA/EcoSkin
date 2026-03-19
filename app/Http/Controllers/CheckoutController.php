<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('checkout.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'payment_method' => 'required|in:bank_transfer,stripe,paypal'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $cart = $request->cart;
                $total = 0;

                // Validate stock and calculate total
                foreach ($cart as $item) {
                    $product = Product::findOrFail($item['id']);
                    // Stock check could be added here
                    $total += $product->price * $item['quantity'];
                }

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total' => $total,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method
                ]);

                foreach ($cart as $item) {
                    $product = Product::find($item['id']);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price
                    ]);
                }

                if ($request->payment_method === 'bank_transfer') {
                    $order->update(['status' => 'pending_transfer']);
                    return response()->json([
                        'success' => true,
                        'redirect' => route('checkout.success', $order->id),
                        'message' => 'Pedido registrado. Por favor realice el pago por transferencia.'
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
            });
        }
        catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al procesar el pedido.'], 500);
        }
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
                        'name' => $item->product->name,
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

    public function success(Order $order)
    {
        // For production, verify payment status here via API/Webhook
        if ($order->payment_method === 'stripe' || $order->payment_method === 'paypal') {
            $order->update(['status' => 'paid']);
        }

        return view('checkout.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        return redirect()->route('cart.index')->with('error', 'El pago fue cancelado.');
    }
}
