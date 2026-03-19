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
                    <thead style="background: var(--color-charcoal); color: var(--color-cream);">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">{{ __('Cliente') }}</th>
                            <th class="py-3">{{ __('Total') }}</th>
                            <th class="py-3">{{ __('Método') }}</th>
                            <th class="py-3">{{ __('Estado') }}</th>
                            <th class="py-3">{{ __('Fecha') }}</th>
                            <th class="px-4 py-3 text-end">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3 align-middle">#{{ $order->id }}</td>
                            <td class="py-3 align-middle">{{ $order->user->name }}</td>
                            <td class="py-3 align-middle">${{ number_format($order->total, 2) }}</td>
                            <td class="py-3 align-middle text-uppercase small">{{ $order->payment_method }}</td>
                            <td class="py-3 align-middle">
                                <span class="badge rounded-pill" style="background: {{ $order->status == 'completed' ? 'var(--color-forest)' : 'var(--color-sage)' }}; color: white;">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-3 align-middle text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
