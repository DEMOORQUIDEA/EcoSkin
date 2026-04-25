@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-serif" style="color: var(--color-charcoal);">{{ __('Orders') }}</h2>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr style="background: #000000;">
                            <th class="px-4 py-3" style="color: #FFFFFF !important;">ID</th>
                            <th class="py-3" style="color: #FFFFFF !important;">{{ __('Cliente') }}</th>
                            <th class="py-3" style="color: #FFFFFF !important;">{{ __('Total') }}</th>
                            <th class="py-3" style="color: #FFFFFF !important;">{{ __('Pago') }}</th>
                            <th class="py-3" style="color: #FFFFFF !important;">{{ __('Logística') }}</th>
                            <th class="py-3" style="color: #FFFFFF !important;">{{ __('Fecha') }}</th>
                            <th class="py-3" style="color: #FFFFFF !important;">{{ __('Teléfono') }}</th>
                            <th class="py-3" style="color: #FFFFFF !important;">{{ __('Dirección') }}</th>
                            <th class="px-4 py-3 text-end" style="color: #FFFFFF !important;">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3 align-middle">#{{ $order->id }}</td>
                            <td class="py-3 align-middle">{{ $order->user->name }}</td>
                            <td class="py-3 align-middle">${{ number_format($order->total, 2) }}</td>
                            <td class="py-3 align-middle">
                                <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : ($order->payment_status == 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }} rounded-pill">
                                    {{ $order->payment_status == 'paid' ? 'Pagado' : ($order->payment_status == 'cancelled' ? 'Cancelado' : 'Pendiente') }}
                                </span>
                            </td>
                            <td class="py-3 align-middle">
                                <span class="badge {{ $order->shipping_status == 'delivered' ? 'bg-success' : ($order->shipping_status == 'shipped' ? 'bg-info text-white' : ($order->shipping_status == 'cancelled' ? 'bg-danger' : 'bg-secondary')) }} rounded-pill">
                                    {{ $order->shipping_status == 'delivered' ? 'Entregado' : ($order->shipping_status == 'shipped' ? 'Enviado' : ($order->shipping_status == 'cancelled' ? 'Cancelado' : 'Preparando')) }}
                                </span>
                            </td>
                            <td class="py-3 align-middle text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 align-middle">{{ $order->shipping_phone ?? 'N/A' }}</td>
                            <td class="py-3 align-middle" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $order->shipping_address }}">
                                {{ $order->shipping_address ?? 'No proporcionada' }}
                            </td>
                            <td class="px-4 py-3 text-end align-middle">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 8px;">
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">{{ __('No hay pedidos registrados.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
