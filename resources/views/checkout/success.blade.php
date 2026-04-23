@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white py-4 text-center">
                    <i class="bi bi-check-circle-fill display-1 mb-3"></i>
                    <h2 class="fw-bold">¡Pago Exitoso!</h2>
                    <p class="mb-0">Gracias por tu compra, {{ $order->user->name }}</p>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h4 class="text-muted">ID del Pedido: <span class="text-dark fw-bold">#{{ $order->id }}</span></h4>
                        <h1 class="display-4 fw-bold text-success">${{ number_format($order->total, 2) }}</h1>
                    </div>

                    <div class="order-details bg-light p-4 rounded-4 mb-4">
                        <h5 class="fw-bold mb-3">Resumen del Pedido</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach($order->items as $item)
                                <li class="d-flex justify-content-between mb-2">
                                    <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                    <span class="fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </li>
                            @endforeach
                            <hr>
                            <li class="d-flex justify-content-between">
                                <span class="fw-bold">Método de Pago:</span>
                                <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                            </li>
                        </ul>
                    </div>

                    @if($order->payment_method === 'bank_transfer')
                        <div class="alert alert-info rounded-4 p-4 mb-4 border-0">
                            <h5 class="fw-bold"><i class="bi bi-bank me-2"></i>Instrucciones de Transferencia</h5>
                            <p class="mb-2">Por favor realice el depósito a la siguiente cuenta:</p>
                            <ul class="mb-0">
                                <li><strong>Banco:</strong> Banco Ejemplo</li>
                                <li><strong>Cuenta:</strong> 1234 5678 9012</li>
                                <li><strong>ID de Referencia:</strong> #{{ $order->id }}</li>
                            </ul>
                            <p class="mt-3 mb-0 small text-muted">Su pedido será procesado una vez confirmado el depósito.</p>
                        </div>
                    @endif

                    <div class="d-grid gap-3 mt-4">
                        <button onclick="window.print()" class="btn btn-success btn-lg rounded-pill shadow-sm py-3 fw-bold">
                            <i class="bi bi-printer-fill me-2"></i>IMPRIMIR TICKET
                        </button>
                        <a href="{{ route('welcome') }}" class="btn btn-outline-success btn-lg rounded-pill shadow-sm py-3" style="color: #48633F; border-color: #48633F;">
                            <i class="bi bi-shop me-2"></i>Regresar a la Tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista Previa y Contenedor de Impresión -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 d-flex justify-content-center">
            <div id="printable-ticket" class="ticket-premium shadow-lg bg-white p-4">
                <div class="ticket-header text-center mb-4">
                    <div class="premium-logo mb-2">
                        <span class="logo-text" style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; font-weight: 600; color: #1B2B1B; letter-spacing: 2px;">EcoSkin</span>
                    </div>
                    <div class="store-info" style="font-family: 'Jost', sans-serif; font-size: 0.9rem; color: #444;">
                        <p class="m-0 fw-bold">CUIDADO NATURAL Y ARTESANAL</p>
                        <p class="m-0">Av. Siempre Viva #123, Col. Centro</p>
                        <p class="m-0">Tel: +52 123 456 7890</p>
                        <p class="m-0">www.ecoskin.com</p>
                    </div>
                    <div class="decorative-line my-3">
                        <div style="border-top: 2px solid #1B2B1B; width: 40%; margin: 0 auto;"></div>
                    </div>
                    <h5 class="fw-bold text-uppercase tracking-widest" style="font-family: 'Jost', sans-serif;">Comprobante de Pago</h5>
                </div>
                
                <div class="ticket-meta mb-4 pb-3 border-bottom dashed" style="font-family: 'Jost', sans-serif; font-size: 0.95rem;">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">FECHA:</span>
                        <span class="fw-bold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">PEDIDO:</span>
                        <span class="fw-bold">#{{ $order->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">CLIENTE:</span>
                        <span class="fw-bold text-end">{{ strtoupper($order->user->name) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">PAGO:</span>
                        <span class="fw-bold">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                </div>

                <div class="order-items mb-4">
                    <table class="table table-sm table-borderless mb-0" style="font-family: 'Jost', sans-serif; font-size: 0.95rem;">
                        <thead class="border-bottom pb-2">
                            <tr class="text-muted small uppercase">
                                <th style="width: 55%;">PRODUCTO</th>
                                <th class="text-center" style="width: 15%;">CANT.</th>
                                <th class="text-end" style="width: 30%;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody class="pt-2">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="py-2">
                                        <div class="fw-bold text-dark">{{ strtoupper($item->product->name) }}</div>
                                        <div class="text-muted extra-small" style="font-size: 0.75rem;">$ {{ number_format($item->price, 2) }} c/u</div>
                                    </td>
                                    <td class="text-center align-middle">{{ $item->quantity }}</td>
                                    <td class="text-end align-middle fw-bold">$ {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="totals-section py-3 border-top border-bottom double mb-4" style="font-family: 'Jost', sans-serif;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 m-0 fw-bold">TOTAL A PAGAR</span>
                        <span class="h4 m-0 fw-bold" style="color: #48633F;">$ {{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <div class="ticket-footer text-center mt-2">
                    <div class="qr-placeholder mb-3">
                        <i class="bi bi-qr-code" style="font-size: 3rem; color: #1B2B1B;"></i>
                    </div>
                    <p class="fw-bold mb-1" style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem;">¡Gracias por tu preferencia!</p>
                    <p class="m-0 italic text-muted" style="font-family: 'Jost', sans-serif; font-size: 0.85rem; line-height: 1.4;">
                        "Cuidamos tu piel con el alma de la naturaleza. Tu compra apoya procesos artesanales y sostenibles."
                    </p>
                    <div class="mt-3 opacity-50 small">
                        <p class="m-0">Siguenos en @EcoSkin_Natural</p>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Modal de Impresión en Progreso -->
<div id="printing-overlay" class="no-print d-none" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.9); z-index: 10000; display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
    <h4 class="fw-bold">Generando Ticket...</h4>
    <p class="text-muted">La impresión debería comenzar en un momento.</p>
</div>

<style>
    .card { transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-5px); }

    .ticket-premium {
        width: 100%;
        max-width: 400px;
        border: 1px solid #eee;
        border-radius: 12px;
        color: #1B2B1B;
        background-color: #fff;
    }

    .border-bottom.dashed { border-bottom: 1px dashed #ccc !important; }
    .border-top.double { border-top: 3px double #1B2B1B !important; }
    .border-bottom.double { border-bottom: 1px double #1B2B1B !important; }

    /* ====================================================
       ESTILOS DE IMPRESIÓN FLEXIBLES (Cualquier impresora)
    ==================================================== */
    @media print {
        @page {
            margin: 0.5cm;
        }
        
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
            height: auto !important;
            overflow: visible !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        /* Ocultar elementos de la interfaz */
        #app > nav, footer, .container > .row:first-child, .btn, .no-print, .eco-search-wrap, .eco-stats-bar {
            display: none !important;
        }

        /* Resetear contenedores para impresión */
        .container, .row, .col-md-6, .py-4 {
            width: 100% !important;
            max-width: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
        }

        /* Ticket autoajustable al centro */
        #printable-ticket {
            display: block !important;
            position: relative !important;
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 300px !important; /* Ideal para tickets, centrado si es A4 */
            padding: 10px !important;
            border: none !important;
            box-shadow: none !important;
            height: auto !important;
            background: #fff !important;
            word-wrap: break-word !important;
        }

        #printable-ticket * {
            color: #000 !important;
            text-shadow: none !important;
            font-size: 8pt !important;
            line-height: 1.2 !important;
        }

        .premium-logo .logo-text {
            font-size: 14pt !important;
            line-height: 1 !important;
            margin-bottom: 2mm !important;
        }

        .store-info p {
            font-size: 7.5pt !important;
            line-height: 1.1 !important;
        }

        .order-items table {
            width: 100% !important;
            table-layout: fixed !important;
        }

        .order-items table td {
            font-size: 8pt !important;
            padding: 1mm 0 !important;
        }

        .totals-section {
            border-top: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
            margin: 2mm 0 !important;
            padding: 1mm 0 !important;
        }

        .totals-section .h5 { font-size: 8.5pt !important; }
        .totals-section .h4 { font-size: 10.5pt !important; }

        .bi-qr-code {
            font-size: 1.5rem !important;
        }
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Al llegar a la pantalla de éxito, borramos permanentemente los artículos que ya se pagaron
        if (typeof getCartKey === 'function') {
            localStorage.removeItem(getCartKey());
            // Actualizamos la cantidad en el ícono del carrito
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
        }
    });
</script>
@endpush

@endsection
