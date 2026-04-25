@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="eco-section-heading mb-4">
        <h2 class="eco-section-heading__title">
            <i class="bi bi-clock-history me-2"></i>Mi Historial de <span class="text-tan">Compras</span>
        </h2>
        <span class="eco-section-heading__line"></span>
    </div>

    @if($orders->count() > 0)
        <div class="table-responsive bg-white rounded-3 shadow-sm p-4">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: var(--color-cream); color: var(--color-charcoal);">
                    <tr>
                        <th class="py-3 px-4 border-0 rounded-start">Pedido #</th>
                        <th class="py-3 px-4 border-0">Fecha</th>
                        <th class="py-3 px-4 border-0">Artículos</th>
                        <th class="py-3 px-4 border-0">Total</th>
                        <th class="py-3 px-4 border-0">Método de Pago</th>
                        <th class="py-3 px-4 border-0 rounded-end">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-4 py-3 fw-bold" style="color: var(--color-forest);">
                                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3 text-muted">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-muted">
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            <td class="px-4 py-3 fw-bold">
                                ${{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-4 py-3 text-capitalize">
                                @if($order->payment_method == 'stripe')
                                    <i class="bi bi-credit-card text-primary me-1"></i> Tarjeta (Stripe)
                                @elseif($order->payment_method == 'paypal')
                                    <i class="bi bi-paypal text-info me-1"></i> PayPal
                                @elseif($order->payment_method == 'bank_transfer')
                                    <i class="bi bi-bank text-secondary me-1"></i> Transferencia
                                @else
                                    {{ $order->payment_method }}
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex flex-column gap-2">
                                    <!-- Estado de Pago -->
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">PAGO:</small>
                                        @if($order->payment_status == 'paid')
                                            <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.7rem;">Pagado</span>
                                        @elseif($order->payment_status == 'cancelled')
                                            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.7rem;">Cancelado</span>
                                        @else
                                            <span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size: 0.7rem;">Pendiente</span>
                                        @endif
                                    </div>
                                    <!-- Estado de Envío -->
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">ENVÍO:</small>
                                        @if($order->shipping_status == 'shipped')
                                            <span class="badge bg-primary rounded-pill px-2 py-1" style="font-size: 0.7rem;">En Camino</span>
                                        @elseif($order->shipping_status == 'delivered')
                                            <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.7rem;">Entregado</span>
                                        @elseif($order->shipping_status == 'cancelled')
                                            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.7rem;">Cancelado</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-2 py-1" style="font-size: 0.7rem;">Preparando</span>
                                        @endif
                                    </div>
                                    
                                    @if($order->payment_status == 'pending' && $order->shipping_status != 'cancelled')
                                        <a href="{{ route('user.orders.pay', $order->id) }}" class="btn btn-sm py-1 px-3 text-white mt-1" style="background: var(--color-forest); font-size: 0.7rem; border-radius: 50px;">
                                            <i class="bi bi-credit-card me-1"></i>Pagar ahora
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links('vendor.pagination.custom') ?? $orders->links() }}
        </div>
    @else
        <div class="eco-empty text-center py-5 bg-white rounded-3 shadow-sm">
            <div class="eco-empty__icon mb-3">
                <i class="bi bi-bag-x" style="font-size: 4rem; color: var(--color-sage);"></i>
            </div>
            <h4 class="mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--color-charcoal);">Aún no tienes compras</h4>
            <p class="text-muted mb-4">Explora nuestro catálogo y descubre lo mejor en cosmética natural.</p>
            <a href="{{ route('welcome') }}" class="btn btn-lg" style="background: var(--color-forest); color: white; border-radius: 50px; padding: 0.5rem 1.5rem;">
                <i class="bi bi-shop me-2"></i>Ir a la tienda
            </a>
        </div>
    @endif
</div>

@endsection

@push('styles')
<style>
.eco-section-heading {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.eco-section-heading__line {
    flex: 1;
    height: 1px;
    background: rgba(162,165,141,0.35);
}
.eco-section-heading__title {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 500;
    font-size: 1.9rem;
    color: var(--color-charcoal);
    white-space: nowrap;
    letter-spacing: 0.02em;
}
.text-tan { color: var(--color-tan) !important; }
</style>
@endpush
