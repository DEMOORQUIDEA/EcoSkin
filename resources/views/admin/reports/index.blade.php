@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0" style="color: var(--color-charcoal); font-family: 'Cormorant Garamond', serif;">
                Reporte de Ventas
            </h1>
            <p class="text-muted">Resumen de ingresos de la tienda</p>
        </div>
        <div>
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Imprimir Reporte
            </button>
        </div>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row g-4 mb-5">
        <!-- Hoy -->
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: var(--color-surface);">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="mb-3" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(130, 157, 100, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-calendar-event text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <h5 class="text-uppercase text-muted fw-bold mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Ventas de Hoy</h5>
                    <h2 class="fw-bold mb-0" style="color: var(--color-forest);">${{ number_format($salesToday, 2) }}</h2>
                </div>
            </div>
        </div>

        <!-- Esta Semana -->
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: var(--color-surface);">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="mb-3" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(130, 157, 100, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-calendar-week text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <h5 class="text-uppercase text-muted fw-bold mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Esta Semana</h5>
                    <h2 class="fw-bold mb-0" style="color: var(--color-forest);">${{ number_format($salesWeek, 2) }}</h2>
                </div>
            </div>
        </div>

        <!-- Este Mes -->
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: var(--color-surface);">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="mb-3" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(130, 157, 100, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-calendar-month text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <h5 class="text-uppercase text-muted fw-bold mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Este Mes</h5>
                    <h2 class="fw-bold mb-0" style="color: var(--color-forest);">${{ number_format($salesMonth, 2) }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Histórico -->
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: var(--color-charcoal); color: var(--color-cream);">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="mb-3" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cash-stack text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                    <h5 class="text-uppercase text-light fw-bold mb-2" style="font-size: 0.85rem; letter-spacing: 1px; opacity: 0.8;">Total Histórico</h5>
                    <h2 class="fw-bold mb-0 text-white">${{ number_format($salesTotal, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ordenes Recientes -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px; background: var(--color-surface);">
        <div class="card-header bg-transparent border-bottom p-4">
            <h5 class="card-title mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Últimas Ventas Completadas</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-0 text-muted" style="font-weight: 600;">ID Pedido</th>
                            <th class="px-4 py-3 border-0 text-muted" style="font-weight: 600;">Cliente</th>
                            <th class="px-4 py-3 border-0 text-muted" style="font-weight: 600;">Fecha</th>
                            <th class="px-4 py-3 border-0 text-muted" style="font-weight: 600;">Método</th>
                            <th class="px-4 py-3 border-0 text-muted text-end" style="font-weight: 600;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-4 py-3 border-light">
                                <span class="fw-bold text-secondary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-4 py-3 border-light">
                                {{ $order->user->name ?? 'Usuario Eliminado' }}
                            </td>
                            <td class="px-4 py-3 border-light text-muted">
                                {{ $order->created_at->format('d/m/Y h:i A') }}
                            </td>
                            <td class="px-4 py-3 border-light">
                                <span class="badge bg-light text-dark border"><i class="bi {{ $order->payment_method === 'paypal' ? 'bi-paypal text-primary' : ($order->payment_method === 'stripe' ? 'bi-credit-card text-info' : 'bi-bank text-secondary') }} me-1"></i>{{ ucfirst($order->payment_method) }}</span>
                            </td>
                            <td class="px-4 py-3 border-light text-end fw-bold text-success">
                                ${{ number_format($order->total, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 mb-2 d-block"></i>
                                No hay ventas recientes
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .navbar, footer, .btn {
        display: none !important;
    }
    body {
        background: white !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}
</style>
@endpush
@endsection
