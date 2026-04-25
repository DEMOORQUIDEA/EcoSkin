@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="font-family: 'Cormorant Garamond', serif; color: var(--color-charcoal);">
            <i class="bi bi-receipt me-2"></i>Detalle del Pedido #{{ $order->id }}
        </h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>Volver a la lista
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Panel de Control y Estado -->
        <div class="col-lg-4 order-lg-last">
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-gear-fill me-2"></i>Control de Pedido</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Estado de Pago</label>
                            <select name="payment_status" class="form-select rounded-3">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pendiente de Pago</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Pagado</option>
                                <option value="cancelled" {{ $order->payment_status === 'cancelled' ? 'selected' : '' }}>Cancelado / Devuelto</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Estado de Envío</label>
                            <select name="shipping_status" class="form-select rounded-3">
                                <option value="pending" {{ $order->shipping_status === 'pending' ? 'selected' : '' }}>Pendiente de Envío</option>
                                <option value="shipped" {{ $order->shipping_status === 'shipped' ? 'selected' : '' }}>Enviado</option>
                                <option value="delivered" {{ $order->shipping_status === 'delivered' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelled" {{ $order->shipping_status === 'cancelled' ? 'selected' : '' }}>Pedido Cancelado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill fw-bold">
                            <i class="bi bi-save me-2"></i>Actualizar Estados
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <h6 class="fw-bold mb-3 small text-uppercase text-muted">Información del Cliente</h6>
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-fill fs-3 text-muted"></i>
                </div>
                <h6 class="mb-1 fw-bold">{{ $order->user->name }}</h6>
                <p class="mb-0 text-muted small">{{ $order->user->email }}</p>
                <hr>
                <a href="mailto:{{ $order->user->email }}" class="btn btn-sm btn-outline-dark w-100 rounded-pill">
                    <i class="bi bi-envelope me-2"></i>Contactar por Email
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Productos -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold">Resumen de Productos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-uppercase">
                                    <th class="ps-4">Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded bg-light me-3 overflow-hidden" style="width: 50px; height: 50px;">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/'.$item->product->image) }}" class="" width="50" height="50" style="object-fit: cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                        <i class="bi bi-box-seam text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block">{{ $item->product->name ?? 'Producto Eliminado' }}</span>
                                                <span class="text-muted small">ID: #{{ $item->product_id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-end fw-bold pe-4">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold py-3">Total del Pedido:</td>
                                    <td class="text-end fw-bold text-primary py-3 pe-4 h4 mb-0">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Envío y Método -->
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white py-3 border-bottom-0">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-truck me-2"></i>Logística de Envío</h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="bg-light rounded-3 p-3">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <p class="mb-1 text-muted small text-uppercase">Destinatario</p>
                                        <p class="fw-bold mb-0">{{ $order->shipping_name ?? $order->user->name }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-1 text-muted small text-uppercase">Dirección Completa</p>
                                        <p class="fw-bold mb-0">{{ $order->shipping_address ?? 'No proporcionada' }}</p>
                                        @if($order->shipping_reference)
                                            <p class="text-muted small mt-1 italic"><i class="bi bi-info-circle me-1"></i>Ref: {{ $order->shipping_reference }}</p>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-1 text-muted small text-uppercase">Teléfono de contacto</p>
                                        <p class="fw-bold mb-0">{{ $order->shipping_phone ?? 'Sin teléfono' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white py-3 border-bottom-0">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-wallet2 me-2"></i>Estado Financiero</h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-3">
                                <p class="mb-1 text-muted small text-uppercase">Método Utilizado</p>
                                <span class="badge bg-light text-dark border p-2 w-100 text-start">
                                    <i class="bi bi-{{ $order->payment_method === 'bank_transfer' ? 'bank' : ($order->payment_method === 'paypal' ? 'paypal' : 'credit-card') }} me-2"></i>
                                    {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1 text-muted small text-uppercase">Pago Consolidado</p>
                                @if($order->payment_status === 'paid')
                                    <div class="alert alert-success py-2 px-3 mb-0 border-0 d-flex align-items-center">
                                        <i class="bi bi-patch-check-fill me-2 fs-4"></i> PAGADO
                                    </div>
                                @elseif($order->payment_status === 'cancelled')
                                    <div class="alert alert-danger py-2 px-3 mb-0 border-0 d-flex align-items-center">
                                        <i class="bi bi-x-circle-fill me-2 fs-4"></i> CANCELADO
                                    </div>
                                @else
                                    <div class="alert alert-warning py-2 px-3 mb-0 border-0 d-flex align-items-center">
                                        <i class="bi bi-hourglass-split me-2 fs-4"></i> PENDIENTE
                                    </div>
                                @endif
                            </div>
                            @if($order->payment_id)
                                <p class="small text-muted mb-0">ID de transacción: <br><span class="text-dark fw-bold">{{ $order->payment_id }}</span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

