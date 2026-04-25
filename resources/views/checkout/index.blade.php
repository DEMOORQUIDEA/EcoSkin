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
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- PASO 1: DATOS DE ENVÍO -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" id="shipping-section">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: bold;">1</div>
                            <h4 class="fw-bold mb-0">Datos de Envío</h4>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" id="shipping_name" class="form-control" placeholder="Ej. Juan Pérez" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Teléfono de Contacto</label>
                                <input type="tel" id="shipping_phone" class="form-control" placeholder="Ej. 1234567890">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Dirección Completa</label>
                                <textarea id="shipping_address" class="form-control" rows="3" placeholder="Calle, Número, Colonia, Ciudad, Código Postal"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Referencias (Opcional)</label>
                                <textarea id="shipping_reference" class="form-control" rows="2" placeholder="Ej. Entre calles, descripción de la fachada..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button class="btn btn-dark px-4 rounded-pill fw-bold" onclick="showPaymentStep()">
                                Continuar al Pago <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- PASO 2: MÉTODO DE PAGO -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 d-none" id="payment-section">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: bold;">2</div>
                            <h4 class="fw-bold mb-0">Selecciona tu Método de Pago</h4>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card payment-card p-4 text-center h-100" onclick="selectPayment('stripe')">
                                    <i class="bi bi-credit-card text-primary display-5 mb-3"></i>
                                    <h6 class="fw-bold">Tarjeta (Stripe)</h6>
                                    <small class="text-muted">Pago seguro con tarjeta</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card payment-card p-4 text-center h-100" onclick="selectPayment('paypal')">
                                    <i class="bi bi-paypal text-info display-5 mb-3"></i>
                                    <h6 class="fw-bold">PayPal</h6>
                                    <small class="text-muted">Paga con tu cuenta PayPal</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card payment-card p-4 text-center h-100" onclick="selectPayment('bank_transfer')">
                                    <i class="bi bi-bank text-success display-5 mb-3"></i>
                                    <h6 class="fw-bold">Transferencia</h6>
                                    <small class="text-muted">Referencia bancaria</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-link text-decoration-none text-muted p-0" onclick="showShippingStep()">
                                <i class="bi bi-arrow-left me-2"></i> Editar datos de envío
                            </button>
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
                        <h5 class="fw-bold mb-4">Resumen de Compra</h5>
                        <div id="checkout-items">
                            <!-- Items dinámicos -->
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total a Pagar</span>
                            <span class="fw-bold h4 text-primary" id="checkout-total">$0.00</span>
                        </div>
                        
                        <button id="process-order" class="btn btn-pay btn-lg w-100 text-white fw-bold rounded-pill disabled" onclick="processOrder()">
                            Confirmar y Pagar
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
    let cart = [];

    function getCheckoutCartKey() {
        @auth
            return 'cart_{{ Auth::id() }}';
        @endauth
        return 'cart_guest';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cartKey = getCheckoutCartKey();
        cart = JSON.parse(localStorage.getItem(cartKey) || '[]');
        if (cart.length === 0) {
            window.location.href = "{{ route('cart.index') }}";
            return;
        }
        renderSummary();
    });

    function showPaymentStep() {
        const name = document.getElementById('shipping_name').value.trim();
        const phone = document.getElementById('shipping_phone').value.trim();
        const address = document.getElementById('shipping_address').value.trim();

        if (!name || !phone || !address) {
            alert('Por favor, completa los campos obligatorios del envío (Nombre, Teléfono y Dirección)');
            return;
        }

        document.getElementById('shipping-section').classList.add('d-none');
        document.getElementById('payment-section').classList.remove('d-none');
        window.scrollTo(0, 0);
    }

    function showShippingStep() {
        document.getElementById('payment-section').classList.add('d-none');
        document.getElementById('shipping-section').classList.remove('d-none');
        window.scrollTo(0, 0);
    }

    function selectPayment(method) {
        selectedMethod = method;
        document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('active'));
        event.currentTarget.classList.add('active');
        
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

    function renderSummary() {
        let html = '';
        let total = 0;
        cart.forEach(item => {
            total += item.price * item.quantity;
            html += `
                <div class="d-flex justify-content-between mb-2">
                    <span class="small">${item.name} x ${item.quantity}</span>
                    <span class="small">$${(item.price * item.quantity).toFixed(2)}</span>
                </div>
            `;
        });
        document.getElementById('checkout-items').innerHTML = html;
        document.getElementById('checkout-total').textContent = `$${total.toFixed(2)}`;
    }

    async function processOrder() {
        const btn = document.getElementById('process-order');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

        try {
            const response = await fetch("{{ route('checkout.process') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: cart,
                    payment_method: selectedMethod,
                    shipping_name: document.getElementById('shipping_name').value,
                    shipping_phone: document.getElementById('shipping_phone').value,
                    shipping_address: document.getElementById('shipping_address').value,
                    shipping_reference: document.getElementById('shipping_reference').value
                })
            });

            const data = await response.json();

            if (data.success) {
                // Borrar carrito inmediatamente al confirmar pedido
                localStorage.removeItem(getCheckoutCartKey());
                
                if (selectedMethod === 'stripe') {
                    window.location.href = data.url;
                } else if (selectedMethod === 'bank_transfer') {
                    window.location.href = data.redirect;
                }
            } else {
                alert(data.message || 'Error al procesar el pago');
                btn.disabled = false;
                btn.textContent = 'Confirmar y Pagar';
            }
        } catch (error) {
            console.error(error);
            alert('Error crítico de red');
            btn.disabled = false;
        }
    }

    function initPayPal() {
        const container = document.getElementById('paypal-button-container');
        if (container.children.length > 0) return;

        paypal.Buttons({
            createOrder: async (data, actions) => {
                const response = await fetch("{{ route('checkout.process') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ cart: cart, payment_method: 'paypal' })
                });
                const orderData = await response.json();
                return actions.order.create({
                    purchase_units: [{
                        amount: { value: cart.reduce((s,i) => s + (i.price * i.quantity), 0).toFixed(2) },
                        custom_id: orderData.order_id
                    }]
                });
            },
            onApprove: (data, actions) => {
                // Borrar carrito inmediatamente al aprobar
                localStorage.removeItem(getCheckoutCartKey());
                return actions.order.capture().then(details => {
                    // El custom_id contiene el ID de la orden que enviamos en createOrder
                    const orderId = details.purchase_units[0].custom_id;
                    window.location.href = "{{ route('checkout.success', ['order' => '__ID__']) }}".replace('__ID__', orderId);
                });
            }

        }).render('#paypal-button-container');
    }
</script>
@endsection
