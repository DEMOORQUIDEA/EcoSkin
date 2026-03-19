@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="font-serif" style="color: var(--color-charcoal);">{{ __('Carritos Abandonados') }}</h2>
        <p class="text-muted">{{ __('Análisis de productos agregados al carrito pero no comprados.') }}</p>
    </div>

    <div class="card shadow-sm border-0 text-center py-5" style="border-radius: 20px; background: white;">
        <div class="card-body">
            <div class="mb-4">
                <i class="bi bi-graph-down-arrow" style="font-size: 4rem; color: var(--color-tan);"></i>
            </div>
            <h4 class="mb-3">{{ __('Monitoreo de Carritos Abandonados') }}</h4>
            <p class="text-muted mx-auto" style="max-width: 500px;">
                Esta sección permitirá visualizar qué productos están siendo "olvidados" en los carritos de los clientes. 
                Actualmente estamos configurando la recolección de datos en tiempo real.
            </p>
            <div class="mt-4">
                <span class="badge rounded-pill px-3 py-2" style="background: var(--color-cream); color: var(--color-sage); border: 1px solid var(--color-sage);">
                    <i class="bi bi-clock-history me-1"></i> {{ __('Próximamente datos estadísticos') }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
