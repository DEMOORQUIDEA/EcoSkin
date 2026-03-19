@extends('layouts.app')

@section('content')
<style>
    .checkout-page {
        background: linear-gradient(135deg, #f6f9fc 0%, #eef2f7 100%);
        min-height: calc(100vh - 76px);
        padding: 4rem 0;
    }
    .payment-card {
        border: 2px solid transparent;
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 16px;
    }
    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .payment-card.active {
        border-color: var(--color-forest);
        background-color: rgba(230,234,221,0.5);
    }
    .checkout-summary {
        position: sticky;
        top: 2rem;
    }
    .btn-pay {
        background: var(--color-forest);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-pay:hover {
        background: var(--color-charcoal);
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(45,45,38,0.25);
    }
</style>

<div class="checkout-page">
    <div class="container">
        <!-- Breadcrumb / Volver -->
        <div class="mb-4">
            <a href="{{ route('user.orders') }}" class="text-decoration-none" style="color: var(--color-forest);">
                <i class="bi bi-arrow-left me-1"></i> Volver a mi Historial
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Completar Pago de Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card payment-card p-4 text-center h-100 {{ $order->payment_method == 'stripe' ? 'active' : '' }}" onclick="selectPayment('stripe')">
                                    <i class="bi bi-credit-card text-primary display-5 mb-3"></i>
                                    <h6 class="fw-bold">Tarjeta (Stripe)</h6>
                                    <small class="text-muted">Pago seguro con tarjeta</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card payment-card p-4 text-center h-100 {{ $order->payment_method == 'paypal' ? 'active' : '' }}" onclick="selectPayment('paypal')">
                                    <i class="bi bi-paypal text-info display-5 mb-3"></i>
                                    <h6 class="fw-bold">PayPal</h6>
                                    <small class="text-muted">Paga con tu cuenta PayPal</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card payment-card p-4 text-center h-100 {{ $order->payment_method == 'bank_transfer' ? 'active' : '' }}" onclick="selectPayment('bank_transfer')">
                                    <i class="bi bi-bank text-success display-5 mb-3"></i>
                                    <h6 class="fw-bold">Transferencia</h6>
                                    <small class="text-muted">Referencia bancaria</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="payment-details" class="card border-0 shadow-sm rounded-4 d-none">
                    <div class="card-body p-4">
                        <div id="stripe-container" class="d-none">
                            <p class="text-muted mb-0">Serás redirigido al portal seguro de Stripe.</p>
                        </div>
                        <div id="paypal-container" class="d-none">
                            <div id="paypal-button-container"></div>
                        </div>
                        <div id="bank-container" class="d-none">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Recibirás las instrucciones después de confirmar el pedido.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 checkout-summary">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Resumen del Pedido</h5>
                        <div id="checkout-items">
                            @foreach($order->items as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">{{ $item->product ? $item->product->name : 'Producto no disponible' }} x {{ $item->quantity }}</span>
                                    <span class="small">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total a Pagar</span>
                            <span class="fw-bold h4 text-primary" id="checkout-total">${{ number_format($order->total, 2) }}</span>
                        </div>
                        
                        <button id="process-order" class="btn btn-pay btn-lg w-100 text-white fw-bold rounded-pill disabled" onclick="processOrder()">
                            <i class="bi bi-shield-lock me-2"></i> Confirmar y Pagar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=MXN"></script>

<script>
    let selectedMethod = null;
    let initialMethod = '@if(in_array($order->payment_method, ["stripe", "paypal", "bank_transfer"])){!! $order->payment_method !!}@endif';

    if(!initialMethod) {
        initialMethod = 'stripe';
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (initialMethod) {
            selectPayment(initialMethod);
        }
    });

    function selectPayment(method) {
        selectedMethod = method;
        document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('active'));
        
        // Find the newly selected card using a slightly different approach as event might not be available
        const currentCard = document.querySelector(`.payment-card[onclick="selectPayment('${method}')"]`);
        if(currentCard) {
            currentCard.classList.add('active');
        } else if(event && event.currentTarget) {
            event.currentTarget.classList.add('active');
        }
        
        document.getElementById('payment-details').classList.remove('d-none');
        document.getElementById('stripe-container').classList.add('d-none');
        document.getElementById('paypal-container').classList.add('d-none');
        document.getElementById('bank-container').classList.add('d-none');
        
        document.getElementById(method + '-container').classList.remove('d-none');
        document.getElementById('process-order').classList.remove('disabled');

        if (method === 'paypal') {
            document.getElementById('process-order').classList.add('d-none');
            initPayPal();
        } else {
            document.getElementById('process-order').classList.remove('d-none');
        }
    }

    async function processOrder() {
        const btn = document.getElementById('process-order');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

        try {
            const response = await fetch("{{ route('user.orders.process-payment', $order->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_method: selectedMethod
                })
            });

            const data = await response.json();

            if (data.success) {
                if (selectedMethod === 'stripe') {
                    window.location.href = data.url;
                } else if (selectedMethod === 'bank_transfer') {
                    // Para transferencia bancaria, vamos a una vista de éxito/pago hecho
                    window.location.href = data.redirect;
                }
            } else {
                alert(data.message || 'Error al procesar el pago');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-shield-lock me-2"></i> Confirmar y Pagar';
            }
        } catch (error) {
            console.error(error);
            alert('Error crítico de red');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-shield-lock me-2"></i> Confirmar y Pagar';
        }
    }

    function initPayPal() {
        const container = document.getElementById('paypal-button-container');
        if (container.children.length > 0) return;

        paypal.Buttons({
            createOrder: async (data, actions) => {
                const response = await fetch("{{ route('user.orders.process-payment', $order->id) }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ payment_method: 'paypal' })
                });
                const orderData = await response.json();
                
                // PayPal total formatting
                const total = "{{ number_format($order->total, 2, '.', '') }}";
                
                return actions.order.create({
                    purchase_units: [{
                        amount: { value: total },
                        custom_id: orderData.order_id
                    }]
                });
            },
            onApprove: (data, actions) => {
                return actions.order.capture().then(details => {
                    const orderId = details.purchase_units[0].custom_id;
                    window.location.href = "{{ route('checkout.success', ['order' => '__ID__']) }}".replace('__ID__', orderId);
                });
            }
        }).render('#paypal-button-container');
    }
</script>
@endsection
